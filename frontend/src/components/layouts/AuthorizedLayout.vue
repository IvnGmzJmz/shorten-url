<template>
  <header>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

    <nav class="navbar">
      <div class="navbar-logo">
        <img :src="logo" alt="Logo" />
      </div>
      <div class="navbar-user">
        <span>{{ user.name }}</span>
        <button @click="logout" class="logout-button"> Logout </button>

      </div>

    </nav>
    <hr class="navbar-separator" />

  </header>
  <body>
    <router-view></router-view>
  </body>
</template>

<script>
import axios from 'axios';

export default {
  data: () => ({
    logo: require('@/assets/logo.png'),
    user: {
      name: '',
      email: '',
    },
    isDropdownOpen: false,
  }),
  methods: {
    fetchUserData() {
      axios.get('http://localhost:81/api/user',{
        headers: {
          Authorization: `Bearer ${localStorage.getItem("auth_token")}`, 
        }
      }).then((response) => {
        console.log(response.data.name);
        this.user.name = response.data.name;
        this.user.email = response.data.email;
      }).catch((error) => {
        console.error('Error fetching user:', error);
      });
    },
    logout() {
      axios.post('http://localhost:81/api/logout',{}, {
          headers: {
              'Authorization': `Bearer ${localStorage.getItem("auth_token")}`
          }
      }).then(() => {
          localStorage.removeItem("auth_token");
          this.$router.push('/login');
      }).catch(error => {
        console.error('Error logging out:', error);
      })
    }
  },
  mounted() {
    this.fetchUserData();
  },
};
</script>

<style>


  body {
      margin: 0px;
  }
  .navbar {
      display: flex;
      align-items: center;
      padding: 10px 20px;
      justify-content:space-between;
  }
  .navbar-logo img {
      max-height: 40px; /* Adjust the logo height as needed */
  }
  .navbar-separator {
      background-color: #ccc; /* Adjust the separator color as needed */
      flex-grow: 1;
      margin: 0px;
  }
  .navbar-user {
      display: flex;
      align-items: center;
      margin-left: 20px; /* Adjust the margin as needed */
  }
  .navbar-user i {
      font-size: 24px; /* Adjust the icon size as needed */
      margin-right: 5px; /* Adjust the spacing between icon and username */
  }
  .logout-button {
    margin-left: 20px;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 10px 20px;
    cursor: pointer;
  }
</style>
