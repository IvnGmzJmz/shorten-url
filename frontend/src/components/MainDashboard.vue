
<template>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

<div class="dashboard-container">
    <div class="dashboard-links">
        <div class="header-section">
          <h1 class="links-title">Your Links</h1>
          <CreateModal class="create-modal-button" @open-modal="openCreateModal" @link-created="handleLinkCreated" />

        </div>
        <div class="links-list">

            <LinkCard
              v-for="link in links"
              :key="link.id"
              :link="link"
              @fetch-links="fetchLinks"
            />
            <div class="pagination" v-if="pagination.total>pagination.per_page">
              <button class="button-pagination" @click="fetchLinks(pagination.current_page - 1)" :disabled="pagination.current_page === 1 || pagination.current_page == null"> <span aria-hidden="true">&lt;</span></button>
              <span class="current-page-text">{{ pagination.current_page ?? 1 }}</span>
              <button class="button-pagination" @click="fetchLinks(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page"><span aria-hidden="true">&gt;</span></button>
            </div>
        </div>

    </div>
</div>
</template>

<script>
import axios from 'axios';
import CreateModal from "@/components/modals/CreateModal.vue";
import LinkCard from '@/components/LinkCard.vue';

export default {
  data(){
    return {
      links: [],
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 1,
        total: 1
      }
    }
  },
  components: {
    CreateModal,
    LinkCard
  },
  methods: {
    openCreateModal() {
      this.$refs.createModal.openModal(); // Trigger the modal from the parent component
    },

    handleLinkEdited() {
      this.fetchLinks();
    },
    fetchLinks(page = 1) {
      axios.get(`http://localhost:81/api/links?page=${page}`,{
        headers: {
          Authorization: `Bearer ${localStorage.getItem("auth_token")}`, 
        }
      }).then((response) => {
        this.links = response.data.data.data;
        this.pagination = response.data.data.pagination;
      }).catch((error) => {
        console.error('Error fetching links:', error);
      });
    },
    handleLinkCreated() {
      this.fetchLinks();
    },
  },
  mounted() {
    this.fetchLinks();
  },
};
</script>

<style scoped>

.current-page-text {
  margin-left: 10px;
  margin-right: 10px;
}

.button-pagination {
  background-color:white;
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: 10px 20px;
}

.create-modal-button {
  display: flex;
  align-items: center;
}

.header-section {
  display: flex;
  width: 100%;
  justify-content: space-between;
}

.links-title {
  font-weight: bolder;
}

.dashboard-container{
    display: flex;
    justify-content: flex-start; /* Center horizontally */
    align-items: center; /* Center vertically */
    height: 100vh; /* Make the container fill the entire viewport height */
    flex-direction: column;
    background: rgb(244,246,250)

}

.dashboard-links{
    display: flex;
    justify-content: start;
    align-items:start;
    width: 70vw;
    flex-direction: column;
}

.links-list {
  display: block;
  width: 100%;
}

button {
  padding: 5px 10px;
  margin-left: 5px;
  cursor: pointer;
}

.create-link-button {
  margin: auto 5px auto 0;
  background-color:mediumblue;
  border: 0;
  border-radius: 5px;
  padding: 10px 20px;
  font-weight: bold;
  color: white;
}

.create-link-button:hover{
  background-color: blue
}


</style>