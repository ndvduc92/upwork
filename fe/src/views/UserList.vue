<template>
  <div class="home">
    <br>
    <h1>
      Active Users
    </h1>
    <input v-on:keyup.enter="onSaveUser" v-model="username"/>
    <div class="">
      <div v-for="user in users" :key="user.id">
        <router-link
          :to="{
            name: 'UserSkill',
            params: { username: user.username }
          }"
        >
          <h2>{{ user.username }}</h2>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios"
import CONSTANTS from '@/helpers/constants'

export default {
  name: "UserList",
  components: {},
  data() {
    return {
      users: [],
      username: ""
    }
  },
  mounted() {
    this.getUsers()
  },
  methods: {
    async onSaveUser() {
       await axios.post(`${CONSTANTS.API_ENDPOINT}/members`, { username: this.username}).then(res => {
        this.getUsers()
        this.username = ""
      }).catch(err => {
        alert("Username already exist.")
      });
    },
    async getUsers() {
      await axios.get(`${CONSTANTS.API_ENDPOINT}/members`).then(res => {
        this.users = res.data
      });
    }
  }
};
</script>