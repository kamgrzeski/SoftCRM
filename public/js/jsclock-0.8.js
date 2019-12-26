/*!
 * JS Clock - jQuery Plugin version 0.8
 * http://thiago-cavalcanti.github.com/JS-Clock/
 *
 * Copyright (c) 2010 Thiago Cavalcanti Pimenta.
 * Dual licensed under the MIT and GPL version 3 licenses.
 * Check mit.txt and gpl.txt on this distribution for the respective
 * licensing text.
 *
 * Date: 2011-01-29 (Sat, 29 Jan 2011)
 */
(function() {
  var $;
  $ = jQuery;
  $.fn.jsclock = function(sTime, oConfig) {
    var sCurrentTime, that;
    that = this;
    sCurrentTime = "";
    if (oConfig == null) {
      oConfig = {};
    }
    $.fn.jsclock.getTime = function() {
      return sCurrentTime;
    };
    $.fn.jsclock.stopClock = function() {
      return oConfig.stopClock = true;
    };
    $.fn.jsclock.startClock = function() {
      if (oConfig.stopClock === true) {
        oConfig.stopClock = false;
        if (sTime === null) {
          return that.jsclock(sTime, oConfig);
        } else {
          return that.jsclock(sCurrentTime, oConfig);
        }
      }
    };
    $.fn.jsclock.toggleClock = function() {
      if (oConfig.stopClock === true) {
        return that.jsclock.startClock();
      } else {
        return that.jsclock.stopClock();
      }
    };
    return this.each(function() {
      var aTime, clientClock, clockwork, iCurrentCenti, iCurrentHour, iCurrentMinute, iCurrentSecond, rValidateTimeString, reverseClockwork, updateTimeString;
      if (typeof sTime === "object") {
        oConfig = sTime;
        sTime = null;
      }
      iCurrentHour = 0;
      iCurrentMinute = 0;
      iCurrentSecond = 0;
      iCurrentCenti = 0;
      updateTimeString = function() {
        var addLeadingZero;
        addLeadingZero = function(iTimeStringFragment) {
          if (iTimeStringFragment < 10 && iTimeStringFragment.length !== 2) {
            iTimeStringFragment = "0" + iTimeStringFragment;
          }
          return iTimeStringFragment;
        };
        iCurrentHour = addLeadingZero(iCurrentHour);
        iCurrentMinute = addLeadingZero(iCurrentMinute);
        iCurrentSecond = addLeadingZero(iCurrentSecond);
        iCurrentCenti = addLeadingZero(iCurrentCenti);
        if (oConfig.showCenti === true) {
          sCurrentTime = "" + iCurrentHour + ":" + iCurrentMinute + ":" + iCurrentSecond + ":" + iCurrentCenti;
        } else {
          sCurrentTime = "" + iCurrentHour + ":" + iCurrentMinute + ":" + iCurrentSecond;
        }
        that.html(sCurrentTime);
        if (oConfig.stopClock === true) {
          return clearTimeout(clockLoop);
        }
      };
      rValidateTimeString = /^(([01][0-9])|(2[0-3])):[0-5][0-9]:[0-5][0-9](:[0-9][0-9])?$/i;
      if (oConfig.countdown != null) {
        if (typeof oConfig.countdown !== "boolean") {
          that.html('countdown value must either be "true" or "false".');
          return false;
        }
      }
      if (oConfig.showCenti != null) {
        if (typeof oConfig.showCenti !== "boolean") {
          that.html('showCenti value must either be "true" or "false".');
          return false;
        }
      }
      if (oConfig.callback != null) {
        if (typeof oConfig.callback !== "function") {
          that.html('callback must be a function!');
          return false;
        }
      }
      if (sTime) {
        if (rValidateTimeString.test(sTime)) {
          aTime = sTime.split(':');
          iCurrentHour = aTime[0];
          iCurrentMinute = aTime[1];
          iCurrentSecond = aTime[2];
          iCurrentCenti = aTime[3];
          if (oConfig.countdown === true) {
            reverseClockwork = function() {
              var baseclock, fullclock, simpleclock;
              baseclock = function() {
                if (iCurrentSecond > 0) {
                  return iCurrentSecond--;
                } else {
                  iCurrentSecond = 59;
                  if (iCurrentMinute > 0) {
                    return iCurrentMinute--;
                  } else {
                    iCurrentMinute = 59;
                    if (iCurrentHour > 0) {
                      return iCurrentHour--;
                    } else {
                      if (typeof oConfig.callback === "function") {
                        oConfig.callback.call(that);
                        return clearTimeout(clockloop);
                      } else {
                        return iCurrentHour = 23;
                      }
                    }
                  }
                }
              };
              simpleclock = function() {
                var clockloop;
                updateTimeString();
                baseclock();
                return clockloop = setTimeout(simpleclock, 1000);
              };
              fullclock = function() {
                var clockloop;
                if (iCurrentCenti > 0) {
                  iCurrentCenti--;
                } else {
                  iCurrentCenti = 99;
                  baseclock();
                }
                updateTimeString();
                return clockloop = setTimeout(fullclock, 10);
              };
              if (oConfig.showCenti === true) {
                return fullclock();
              } else {
                return simpleclock();
              }
            };
            return reverseClockwork();
          } else {
            clockwork = function() {
              var baseclock, fullclock, simpleclock;
              baseclock = function() {
                if (iCurrentSecond < 59) {
                  return iCurrentSecond++;
                } else {
                  iCurrentSecond = 0;
                  if (iCurrentMinute < 59) {
                    return iCurrentMinute++;
                  } else {
                    iCurrentMinute = 0;
                    if (iCurrentHour < 23) {
                      return iCurrentHour++;
                    } else {
                      return iCurrentHour = 0;
                    }
                  }
                }
              };
              simpleclock = function() {
                var clockLoop;
                baseclock();
                updateTimeString();
                return clockLoop = setTimeout(simpleclock, 1000);
              };
              fullclock = function() {
                var clockLoop;
                if (iCurrentCenti < 99) {
                  iCurrentCenti++;
                } else {
                  iCurrentCenti = 0;
                  baseclock();
                }
                updateTimeString();
                return clockLoop = setTimeout(fullclock, 10);
              };
              if (oConfig.showCenti === true) {
                return fullclock();
              } else {
                return simpleclock();
              }
            };
            return clockwork();
          }
        } else {
          return that.html('Time string <strong>must</strong> be either in the format\
            "HH:MM:SS" or in the "HH:MM:SS:CC" format. Hours, minutes and \
            seconds are all <strong>REQUIRED</strong>, as are the leading zeros, \
            if any. Centiseconds are entirely optional, even if showCenti is \
            true.');
        }
      } else {
        if (oConfig.countdown === true) {
          that.html('You must specify a time string to countdown from!');
          return false;
        } else {
          clientClock = function() {
            var baseclock, fullclock, simpleclock;
            baseclock = function() {
              var oCurrentDate;
              oCurrentDate = new Date();
              iCurrentHour = oCurrentDate.getHours();
              iCurrentMinute = oCurrentDate.getMinutes();
              return iCurrentSecond = oCurrentDate.getSeconds();
            };
            simpleclock = function() {
              var clockLoop;
              baseclock();
              updateTimeString();
              return clockLoop = setTimeout(simpleclock, 1000);
            };
            fullclock = function() {
              var bFirstTime, oCurrentDate;
              if (typeof bFirstTime != "undefined" && bFirstTime !== null) {
                if (iCurrentCenti < 99) {
                  iCurrentCenti++;
                } else {
                  iCurrentCenti = 0;
                  baseclock();
                }
              } else {
                baseclock();
                oCurrentDate = new Date();
                iCurrentCenti = oCurrentDate.getMilliseconds().toString().substr(0, 2);
                bFirstTime = true;
              }
              updateTimeString();
              return setTimeout(fullclock, 10);
            };
            if (oConfig.showCenti === true) {
              return fullclock();
            } else {
              return simpleclock();
            }
          };
          return clientClock();
        }
      }
    });
  };
}).call(this);
