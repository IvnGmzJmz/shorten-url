
<template>
  <div class="login-container">
    <base-auth-form
      :title="title"
      :submitButtonText="submitButtonText"
      :bottomText="bottomText"
      :linkText="linkText"
      :bottomLink="bottomLink"
      :customSubmitMethod="login"
    ></base-auth-form>
  </div>
</template>

<script>
    import axios from 'axios';
    import BaseAuthForm from './BaseAuthForm.vue';

    export default {
        components: {
            BaseAuthForm
        },
        data() {
            return {
            title: 'Login and start sharing',
            submitButtonText: 'Log In',
            bottomText: "Don't have an account?",
            linkText: 'Sign up',
            bottomLink: '/signup',
            };
        },
        methods: {
            async login(data) {
                try {
                    const response = await axios.post('http://localhost:81/api/login', data, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                    })

                    const token = response.data.token;
                    localStorage.setItem('auth_token', token);
                    this.$router.push('/');
                } catch (error) {
                    console.error('Login error:', error);
                }
            },
        },
    };
</script>

<style scoped>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: start;
        height: 100vh; 
    }

       .sign-up-text > a {
        color: blue;
    }

</style>