<template>
  <div class="add-new-url">
    <form @submit.prevent="handleSubmit" class="url-form">
      <div class="form-group">
        <input
          type="text"
          id="title"
          v-model="title"
          class="form-control"
          placeholder="Title"
          required
        />
      </div>
      <div class="form-group">
        <input
          type="text"
          id="url"
          v-model="url"
          placeholder="URL"
          class="form-control"
          required
        />
      </div>
      <button type="submit" class="btn btn-primary">Add URL</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "",
      url: "",
    };
  },
  methods: {
    handleSubmit() {
      // Handle form submission here
      const newUrl = {
        title: this.title,
        url: this.url,
      };

      // You can emit an event to send the data to the parent component
      this.$emit("add-url", newUrl);

      // Clear form fields
      this.title = "";
      this.url = "";
    },
  },
};
</script>

<style scoped>
    .add-new-url {
        width: 70vw;
        margin-top: 20px;
    }

    .url-form {
        display: flex;
        align-items: center;
    }

    .form-group {
        flex: 1;
        margin-right: 10px;
    }

    .form-group > input {
        padding: 10px;
        border: 1px solid #ccc; 
        margin-right: 10px;
        border-radius: 5px;
    }

    .form-control {
        width: 90%;
    }

    button {
        padding: 10px;
        background-color: mediumblue;
        color: white;
        font-weight: bold;
        border: 0px;
        border-radius: 10px;
        padding: 10px 20px;
        cursor: pointer;

    }
</style>
