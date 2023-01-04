<template>
  <div class="col-8 offset-2">
    <br />
    <section class="add">
      <div class="row row-cols-lg-auto g-3 align-items-center">
        <div class="col-12">
          <div class="input-group">
            <div class="input-group-text">Skill</div>
            <input type="text" class="form-control"  v-model="skill.skill">
          </div>
        </div>

        <div class="col-12">
          <input class="form-range" type="range" v-model="skill.level" min="0" max="10" />
        </div>

        <div class="col-12">
          <button @click="onSaveSkill" class="btn btn-sm btn-success">{{ skill.id ? "Update" : "Add"}}</button>
        </div>
      </div>
    </section>
    <br />
    <table v-if="skills.length">
      <tr>
        <th>Skill</th>
        <th>Level</th>
        <th>Action</th>
      </tr>
      <tr v-for="(skill, index) in skills" :key="index">
        <td> <span @click="onUpdate(skill)" class="skill-name">{{ skill.skill }}</span></td>
        <td>
          <div class="progress">
            <div
              class="progress-bar"
              role="progressbar"
              :style="{ width: parseInt(skill.level) * 10 + '%' }"
              aria-valuemin="0"
              aria-valuemax="100"
            >
              {{ parseInt(skill.level) * 10 }}%
            </div>
          </div>
        </td>
        <td>
          <svg
            @click="onDelete(skill.id)"
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-trash"
            viewBox="0 0 16 16"
          >
            <path
              d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"
            />
            <path
              fill-rule="evenodd"
              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
            />
          </svg>
        </td>
      </tr>
    </table>
  </div>
</template>
<script>
import axios from "axios";
import CONSTANTS from '@/helpers/constants'

const defautSkill = {
  id: null,
  level: 5,
  skill: "",
}

export default {
  data() {
    return {
      skills: [],
      skill: defautSkill
    };
  },
  mounted() {
    this.getSkills()
  },
  methods: {
    async getSkills() {
      await axios.get(`${CONSTANTS.API_ENDPOINT}/members/${this.$route.params.username}/skills`).then((res) => {
        this.skills = res.data;
      });
    },
    async onSaveSkill() {
      if (!this.skill.skill) {
        alert("Skill is required!")
        return
      }
      if (!this.skill.id) {
        await axios.post(`${CONSTANTS.API_ENDPOINT}/members/${this.$route.params.username}/skills`, this.skill).then(res => {
          this.getSkills()
          this.skill = defautSkill
        });
      } else {
        await axios.put(`${CONSTANTS.API_ENDPOINT}/members/${this.$route.params.username}/skills/${this.skill.id}`, this.skill).then(res => {
          this.getSkills()
          this.skill = defautSkill
        });
      }
    },
    async onDelete(id) {
      await axios.delete(`${CONSTANTS.API_ENDPOINT}/members/${this.$route.params.username}/skills/${id}`, this.skill).then(res => {
        this.getSkills()
        if (this.skill.id) {
          this.skill = defautSkill
        }
      });
    },
    async onUpdate(skill) {
      this.skill = skill
    },
  },
};
</script>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,
th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
svg {
  margin: 5px;
  cursor: pointer;
}
.skill-name {
  cursor: pointer;
}
</style>
