<template>
    <v-content class="loginPage">
        <v-container fluid fill-height>
            <v-layout justify-center>
                <v-flex xs12 sm8 md4>
                    <div class="text-xs-center">
                        <h1 class="logo-title">SoftCRM</h1>
                        <br>
                    </div>
                    <v-card class="elevation-1">
                        <v-toolbar color="#151c3d" class="white--text">
                            <v-toolbar-title> Login Page</v-toolbar-title>

                        </v-toolbar>
                        <v-card-text>
                            <v-form
                                    ref="form"
                                    v-model="valid"
                                    lazy-validation
                            >
                                <v-text-field prepend-icon="person"
                                              name="username"
                                              placeholder="username"
                                              type="text" id="username"
                                              required
                                              :rules="nameRules"
                                              v-model="credentials.username"
                                >
                                </v-text-field>

                                <v-text-field prepend-icon="lock"
                                              name="password"
                                              placeholder="Password"
                                              type="password"
                                              id="password"
                                              required
                                              :rules="nameRules"
                                              v-model="credentials.password"
                                >
                                </v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                    v-on:click="validate()"
                                    :loading="loading"
                                    :disabled="disableButtonIfFormIsEmpty()"
                                    color="#151c3d"
                                    class="white--text"


                            >
                                Login
                                <v-icon right v-if="">{{ iconName }}</v-icon>
                            </v-btn>

                        </v-card-actions>
                    </v-card>

                    <v-card-actions class="justify-center black--text">
                        &copy; Kamil Grzechulski {{ new Date().getFullYear() }}
                    </v-card-actions>
                </v-flex>

            </v-layout>

        </v-container>
    </v-content>
</template>

<script>
    export default {
        mounted() {
        },
        created() {
            this.checkIfAdminIsAlreadyLoggedIn();
            this.checkIfAdminIsLoggedOut();
        },

        data() {
            return {
                valid: true,
                credentials: {
                    username: '',
                    password: ''
                },

                warning: '',
                success: '',
                iconName: '',
                loading: false,

                nameRules: [
                    v => !!v || 'Field is required'
                ],
            }
        },
        props: [],
        computed: {},
        methods: {
            disableButtonIfFormIsEmpty() {
                if (this.credentials.username === '' || this.credentials.password === '') {
                    this.iconName = 'block';
                    return true;
                } else {
                    this.iconName = 'check_circle';
                    return false;
                }
            },
            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },
            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },
            validate() {
                if (this.$refs.form.validate()) {
                    this.submit();
                }
            },
            checkIfAdminIsLoggedOut() {
                if (this.$route.query.logout) {
                    this.logout = this.$route.query.logout;
                    this.success = this.handleSuccess('You have been successfully logged out!');
                }
            },
            checkIfAdminIsAlreadyLoggedIn() {
                this.$axios
                    .get(`./api/admin/login/check`, [])
                    .then((response) => {
                        this.$router.push('dashboard');
                    })
            },

            submit() {
                this.warning = false;
                this.success = false;

                let credentials = {
                    username: this.credentials.username,
                    password: this.credentials.password
                };
                this.loading = true
                this.$axios
                    .post(`./api/admin/login`, credentials)
                    .then((response) => {
                        console.log(response);
                        this.success = this.handleSuccess(response.data.success.message);
                        localStorage.setItem('api_token', response.data.success.data.access_token);
                        this.$router.push('dashboard');
                        this.loading = false
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.warning = this.handleError(error.response.data.message);
                        } else if (error.response.status === 500) {
                            this.warning = this.handleError('Something went wrong. Please, contact with admin.');
                        } else if (error.response.data.error.message) {

                            this.warning = this.handleError(error.response.data.error.message);
                        } else {
                            this.warning = this.handleError('Wrong username or password.');
                        }
                        this.loading = false
                    });
            },
        }
    }
</script>

<style>
    .loginPage {
        margin-top: 100px;
    }
</style>