<template>
<div class="card">
    <div class="card-header">
        <img class="circular-image" :src="getFavIcon(link.url)" alt="User Image" />

        <div class="card-info">
            <h3 class="title">{{ link.title }}</h3>
            <p class="subtitle">{{ host+'/'+link.short_url }}</p>
            <p class="body">{{ link.url }}</p>

        </div>
    </div>
    <div class="card-footer">
        <div class="operation-buttons">
            <button class="icon-button" @click="copyClipboard(link.short_url)"><font-awesome-icon icon="fa-regular fa-clipboard" /> Copy</button>
            <button class="icon-button" @click="openEditModal(link)" ><font-awesome-icon icon="fa-regular fa-edit" /></button>
            <button class="icon-button" @click="deleteLink(link.id)"><font-awesome-icon icon="fa-regular fa-trash-can" /></button>
        </div>
        <div class="link-metadata">
            <span class='metadata-text'><font-awesome-icon icon="fa-regular fa-calendar" /> {{link.created_at}} </span>  
            <span class='metadata-text'><font-awesome-icon icon="fa-regular fa-chart-bar" /> Visitas: {{link.url_visits}} </span>    
        </div>
    </div>
</div>
<EditModal :item="itemToEdit" @link-edited="handleLinkEdited" ref="editModal" />

</template>

<script>

import axios from 'axios';
import EditModal from "@/components/modals/EditModal.vue";

export default {
    components: {
        EditModal
    },
    props: {
        link: Object,
    },
    data() {
        return {
            host: location.host,
            itemToEdit: null,
        }
    },
    methods: {
        openEditModal(item) {
            this.itemToEdit = item;
            this.$refs.editModal.openModal();
        },
        deleteLink(linkId) {
            axios.delete(`http://localhost:81/api/links/${linkId}`,{
                headers: {
                Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                },
            }).then(()=> {
                this.$emit("fetch-links", this.link);
            }).catch((error) => {
                console.error('Error deleting link:', error);
            });
        },
        async copyClipboard(short_url) {
            try{
                await navigator.clipboard.writeText(location.host+'/'+short_url)
            }catch (err) {
                console.error('Failed to copy: ', err)
            }
        },
        getFavIcon(url) {
            try{
              let faviconUrl = new URL(url);
              let domain = faviconUrl.hostname;
              return faviconUrl.protocol+domain + '/favicon.ico';
            }catch (err){
              console.error('Failed to load Favicon');
              return require('@/assets/logo.png');

            }
 
        }
    }
}


</script>

<style scoped>

.circular-image {
  width: 50px; /* Adjust the width and height as needed */
  height: 50px;
  border-radius: 50%; /* Makes the image circular */
  margin-right: 30px; /* Adds spacing between the image and text */
}

.link-metadata {
  display: flex;
  justify-content: center;
}

.metadata-text {
  font-size: 14px;
  color: grey;
  padding:10px;
}

.operation-buttons {
  display: flex;
  justify-content: center;
}
.card {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 20px 30px 30px 30px;
    border-radius: 15px;
    margin-bottom: 10px;
    background: white;
    height: 10vh;
}

.card-header {
  display: flex;
  flex: 3;
  align-items: center;
}

.card-info {
  flex-grow: 1;
  text-align: left;
}

.title {
  font-weight: bold;
  margin: 0 0 10px 0;
}

.subtitle {
  margin: 0;
  color: blue;
  margin: 0 0 10px 0;

}

.body {
  margin: 0;
  font-size: 14px;
}
.card-footer {
  display: flex;
  flex: 1;
  justify-content: space-between;
  flex-direction: column;
  height: 100%;
}

button {
  padding: 5px 10px;
  margin-left: 5px;
  cursor: pointer;
}

.card.selected {
  background-color: #f0f0f0; /* You can change this color */
}

.links-list {
    display: block;
}

.icon-button {
  background-color:white;
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: 10px 20px;
}

.icon-button:hover {
  background-color: #f0f0f0; /* Change background color on hover (optional) */
}

</style>