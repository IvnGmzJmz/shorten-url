<template>
  <div>
    <p>Redirecting...</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  
  mounted() {
    const shortUrl = this.$route.params.shortUrl;

    axios.get(`http://localhost:81/api/links/map/${shortUrl}`)
      .then(response => {
        const originalUrl = response.data.data;
        window.location.href = originalUrl;

      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
};
</script>
