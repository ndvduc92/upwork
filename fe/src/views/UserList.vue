<template>
  <div class="container">
    <br />
    <h2>Active Users</h2>
    <div class="mb-3">
      <input
        type="text"
        class="form-control"
        id="formGroupExampleInput"
        v-on:keyup.enter="onSaveUser"
        v-model="username"
        placeholder="Enter username and press Enter"
      />
    </div>
    <br />
    <ul class="list-group">
      <li class="list-group-item" v-for="user in users" :key="user.id">
        <router-link
          :to="{
            name: 'UserSkill',
            params: { username: user.username },
          }"
        >
          <span>{{ user.username }}</span>
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from "axios";
import CONSTANTS from "@/helpers/constants";

export default {
  name: "UserList",
  components: {},
  data() {
    return {
      users: [],
      username: "",
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    async onSaveUser() {
      if (!this.username) {
        alert("Username is required")
        return
      }
      if (!this.username.match(/^[0-9a-z]+$/)) {
        alert("The username must be alphanumeric characters only")
        return
      }
      await axios
        .post(`${CONSTANTS.API_ENDPOINT}/members`, { username: this.username })
        .then((res) => {
          this.getUsers();
          this.username = "";
        })
        .catch((err) => {
          alert("Username already exist.");
        });
    },
    async getUsers() {
      await axios.get(`${CONSTANTS.API_ENDPOINT}/members`).then((res) => {
        this.users = res.data;
      });
    },
  },
};
</script>
