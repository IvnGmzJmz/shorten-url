
<template>
  <div class="signup-container">
    <base-auth-form
      :title="title"
      :submitButtonText="submitButtonText"
      :bottomText="bottomText"
      :linkText="linkText"
      :bottomLink="bottomLink"
      :customSubmitMethod="signup" 
      :showAdditionalFields="true" 
    ></base-auth-form>
  </div>
</template>

<script>
    import axios from 'axios';
    import BaseAuthForm from './BaseAuthForm.vue';

    export default {
        components: {
            BaseAuthForm,
        },
        data() {
            return {
                title: 'Create your account',
                submitButtonText: 'Sign Up with Email',
                bottomText: 'Already have an account?',
                linkText: 'Log In',
                bottomLink: '/login',
            };
        },
        methods: {
            async signup(data) {
                try {
                    const response = await axios.post('http://localhost:81/api/register', data, {
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

.signup-container {
    display: flex;
    justify-content: center;
    align-items: start;
    height: 100vh; 
}

.forgot-password {
    color: blue;
    cursor: pointer;
    font-size: 14px;
    text-align: right;
    margin-bottom: 20px;
    margin-top: 5px;
}

.log-in-text> a {
    color: blue;
}
</style>