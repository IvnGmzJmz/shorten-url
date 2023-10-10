<template>
  <div>
    <div v-if="showModal" class="modal">
      <div class="edit-modal-content">
        <form @submit.prevent="editItem" class="edit-form">
          <h2 class="modal-title">Edit Item</h2>
          <div class="form-group">
            <input v-model="currentItem.title" type="text" id="title" placeholder="Title" />
          </div>
          <div class="form-group">
            <input v-model="currentItem.url" type="text" id="url" placeholder="URL" />
          </div>
          <div class="form-group">
            <input v-model="currentItem.short_url" type="text" id="short_url" placeholder="Alias" />
          </div>
          <div class="form-buttons">
            <button type="submit">Edit</button>
            <button @click="showModal = false" class="close-button">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  props: {
    item: Object, 
  },
  data() {
    return {
      showModal: false,
      currentItem: {
        id: '',
        title: '', 
        url: '',
        short_url:''
      },
    };
  },
  methods: {
    editItem() {
  
      axios.put(`http://localhost:81/api/links/${this.item.id}`,this.currentItem,{
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`, 
        }
      }).then((response) => {
        this.$emit('link-edited', response.data.data);
        this.showModal=false;
      }).catch((error) => {
        console.error('Error creating link:', error)
      });
    },
    openModal() {
        this.showModal = true;
    }
  },
  watch: {
    item: {
        handler(newValue) {
            if (newValue !== null) {
                this.currentItem.title = newValue.title || '';
                this.currentItem.url = newValue.url || '';
                this.currentItem.short_url = newValue.short_url || '';
            }
        },
        immediate: true
    }
  }
};
</script>

<style scoped>

.show-edit-modal-button {
background-color:#007bff;
border: 0;
border-radius: 10px;
padding: 10px 20px;
cursor:pointer;
color:white;
font-weight: bold;

}

.form-buttons {
  display:flex;
}

.modal-title {
  text-align: left;
  margin: 0 0 20px 0;
}
.modal {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1000;
}

.edit-modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
  max-width: 400px;
  width: 100%;
  text-align: center;
}

/* Form Styles */
.edit-form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 20px;
  display: flex;
}
input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button[type="submit"] {
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  cursor: pointer;
  margin-right: 10px;
}

button[type="submit"]:hover {
  background-color: #0056b3;
}

/* Close Button Styles */
.close-button {
  background-color: #ccc;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  cursor: pointer;
}

.close-button:hover {
  background-color: #999;
}

/* Responsive Styles */
@media (max-width: 480px) {
  .edit-modal-content {
    max-width: 90%;
  }
}
</style>
