
<template>
  <header>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

    <nav class="navbar">
        <div class="navbar-logo">
          <img :src=logo alt="Logo" />
        </div>
    </nav>
    <hr class="navbar-separator" />

    </header>
    <body>
        <router-view></router-view>
    </body>
</template>

<script>
    export default{
        data: () => ({
            logo: require('@/assets/logo.png')
        })
    }
</script>

<style>
    body{
        margin: 0 8px 8px 8px;
    }
    .navbar {
        display: flex;
        align-items: center;
        padding: 10px 20px;
    }

    .navbar-logo img {
        max-height: 40px; /* Adjust the logo height as needed */
    }

    .navbar-separator {
        background-color: #ccc; /* Adjust the separator color as needed */
        flex-grow: 1;
        margin: 0 8px 0 8px;
    }
</style>