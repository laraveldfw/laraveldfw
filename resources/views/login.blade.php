@extends('layouts.material')

@section('content')
    <section ng-app="LoginApp">
        <form name="loginForm"
              novalidate
              ng-controller="LoginController"
              ng-submit="login(loginForm)">
            <div flex="100"
                 flex-md="60"
                 flex-offset-md="20"
                 flex-lg="50"
                 flex-offset-lg="25"
                 flex-xl="40"
                 flex-offset-xl="30">
                <div layout="column"
                     style="margin-top: 10%;">
                    <md-input-container>
                        <label>Email</label>
                        <input type="text"
                               required
                               name="email"
                               id="email"
                               ng-pattern="emailRegex"
                               ng-model="email" />
                        <div ng-messages="loginForm.email.$error">
                            <div ng-message="required">An email is required</div>
                            <div ng-message="pattern">Not a valid email</div>
                        </div>
                    </md-input-container>
                    <md-input-container ng-hide="forgotPwd">
                        <label>Password</label>
                        <input type="password"
                               ng-required="!forgotPwd"
                               id="password"
                               name="password"
                               maxlength="72"
                               ng-model="password" />
                        <div ng-messages="loginForm.password.$error">
                            <div ng-message="required">A password is required</div>
                        </div>
                    </md-input-container>
                </div>
                <div layout-gt-sm="row"
                     layout="column"
                     layout-align-gt-sm="space-between center"
                     layout-align="center center">
                    <md-checkbox
                            ng-model="remember"
                            aria-label="Remember Your Session"
                            ng-hide="forgotPwd">
                        Remember Me
                    </md-checkbox>
                    <md-checkbox ng-model="forgotPwd" aria-label="Forgot my password">
                        Forgot Password
                    </md-checkbox>
                    <md-button class="md-raised" type="submit" ng-class="forgotPwd ? '' : 'md-primary'" ng-disabled="loginForm.$invalid">
                        @{{ forgotPwd ? 'Send Reset Email' : 'Sign In' }}
                    </md-button>
                </div>
            </div>
        </form>
    </section>
    @endsection

@section('footerScripts')
    <script src="{{ elixir('js/login.js') }}" type="text/javascript"></script>
    @endsection