<template>
  <div class="container">
    <div class="card">
      <div class="card-header">Create Album</div>

      <div class="row">
        <div class="col-md-8 offset-md-2">
          <form v-on:submit.prevent="onSubmit" style="margin: 20px">
            <div class="form-group">
              <label>Title</label>
              <input
                type="text"
                v-model="title"
                placeholder="Title"
                v-bind:class="{ 'is-invalid': errorTitle }"
                class="form-control"
              />
              <div class="invalid-feedback">{{ errorTitle }}</div>
            </div>

            <div class="form-group">
              <label>Description</label>
              <input placeholder="Description" type="text" v-model="desc" class="form-control" />
            </div>

            <div class="form-group">
              <label>Categoria</label>
              <select name="select">
                <option value="1">Cumpleaños</option>
                <option value="2" >Fiestas año nuevo</option>
                <option value="3">Eventos</option>
              </select>
              <v-select v-model="selected" :options="['Vue.js','React']"></v-select>
            </div>
      

            <button type="submit" class="btn btn-lg btn-primary">Go!</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vSelect from 'vue-select'

export default {
  name: "album-create",
  props: ["app"],
  data() {
    return {
      title: "",
      errorTitle: null,

      desc: ""
    };
  },

  mounted() {
    if (this.app.user === null) {
      this.app.$router.push({ name: "auth.login" });
    }
  },

  methods: {
    onSubmit() {
      let $this = this;

      if (this.title.length < 3) {
        this.errorTitle = "Title has to be at least 6 characters long";
        return null;
      }

      let data = {
        title: $this.title,
        desc: $this.desc
      };

      this.app.$store.commit("setLoading", true);

      this.app.request.post("album", data).then(response => {
        this.app.$store.commit("setLoading", false);
        this.app.$router.push({
          name: "album.show",
          params: { id: response.data.id }
        });
      });
    }
  }
};
</script>

<style scoped>
</style>