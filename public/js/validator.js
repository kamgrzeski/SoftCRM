var formValidator = function(options) {
	options = options || {};
	
	//extend the default options
	//this just does a shallow copy, but that's ok in our case
	this.options = {};
	for(var i in this.defaults) {
		this.options[i] = options[i] || this.defaults[i];
	}
}

//default configuration options
//you can override these to change them globally
formValidator.prototype.defaults = {
	addError: function(field, message) {},
	removeError: function(field) {},
	rules: {},
	onErrors: function(errors, event) {}
};

formValidator.prototype.validateField = function(key, event) {
	try {
		this.runValidation(key, event);
		this.clearError(key);
		return true;
	}
	catch(message) {
		var field = this.getField(key);
		if(!field) return true;
		
		this.options.addError(field, message);
		
		var errors = [
			{
				field: field,
				message: message
			}
		];
		
		this.options.onErrors(errors, event);
		
		return false;
	}
}
formValidator.prototype.validateFields = function(keys,event) {
	//passthrough for validateFields(event)
	if(!(keys instanceof Array)) {
		event = keys;
		keys = this.getAllKeys();
	}
	
	var errors = [];
	
	for(var i in keys) {
		try {
			this.runValidation(keys[i], event);
			this.clearError(keys[i]);
		}
		catch(message) {
			var field = this.getField(keys[i]);
			if(!field) continue;
			
			this.options.addError(field, message);
			
			errors.push(
				{
					field: field,
					message: message
				}
			);
		}
	}
	
	if(errors.length) {
		this.options.onErrors(errors, event);
		return false;
	}
	else {
		return true;
	}
}

formValidator.prototype.runValidation = function(key, event) {
	//if a rule exists for this field, run it
	//the rule will throw an exception if it fails
	if(typeof this.options.rules[key] !== 'undefined') {
		var rule = this.options.rules[key];
		var field = this.getField(key);
		
		if(!field) return true;
		
		rule.validate(field, event);
	}
	
	return true;
}

formValidator.prototype.getField = function(key) {
	if(typeof this.options.rules[key] !== 'undefined') {
		var field = this.options.rules[key].field;
		
		if(!field) return false;
		else if(this.isFunction(field)) return field();
		else return field;
	}
	return false;
}

formValidator.prototype.getAllKeys = function() {
	var keys = [];
	for(var i in this.options.rules) {
		keys.push(i);
	}
	return keys;
}

formValidator.prototype.clearError = function(key) {
	var field = this.getField(key);
	if(!field) return;
	
	this.options.removeError(field);
}

formValidator.prototype.clearErrors = function(keys) {
	if(!keys) keys = this.getAllKeys();
	
	for(var i in keys) {
		this.clearError(keys[i]);
	}
}

formValidator.prototype.isFunction = function(obj) {
	return obj == null ?
		false :
		Object.prototype.toString.call(obj) === '[object Function]';
}
