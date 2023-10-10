<template>
  <div class="form-container">
    <h1>{{ title }}</h1>
    <form @submit.prevent="submitForm">

      <div class="additional-elements-container" v-if="showAdditionalFields">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" v-model="username" required>
      </div>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" v-model="email" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" v-model="password" required>

      <button type="submit">{{ submitButtonText }}</button>
      <p>{{ bottomText }} <router-link :to="bottomLink">{{ linkText }}</router-link></p>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    submitButtonText: String,
    bottomText: String,
    linkText: String,
    bottomLink: String,
    customSubmitMethod: Function,
    showAdditionalFields: Boolean, 
  },
  data() {
    return {
      email: '',
      password: '',
      username: '',
    };
  },
  methods: {
    async submitForm() {
      try {
            const data = {
                email: this.email,
                password: this.password,
                name: this.username
            };
            await this.customSubmitMethod(data);
        } catch (error) {
        console.error('Form submission error:', error);
      }
    },
  },
};
</script>

<style scoped>

form {
    display: flex;
    flex-direction: column;
}

label {
  text-align: left;
  margin-bottom: 6px;
  color: #555;
}

input {
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 3px;
  font-size: 16px;
}

button {
  background-color: blue;
  color: #fff;
  border: none;
  border-radius: 3px;
  padding: 10px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: cadetblue;
}

.additional-elements-container {
    display: contents;
}

</style>