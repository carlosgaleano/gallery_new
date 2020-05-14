<template>
  <div class="container" style="height: 100%;margin-buttom: 50px">
    <div class="jumbotron" v-if="app.user" style="text-align: center">
      <h1 iid="banner" class="display-4"></h1>
      <!-- {{this.idprimario+'  id primario'}} -->
      <!-- {{info}}
      {{albums}}-->
    </div>

    <spinner
      class="bigSpinner"
      size="massive"
      line-fg-color="#4CAF50"
      v-if="loading"
      message="Loading..."
    ></spinner>
    <div class="row" v-else>
      <div class="col-md-3" v-for="(album, index) in albums" v-bind:key="index">
        <div class="card album" @click="goToAlbum(album)">
          <!--  {{album}} -->
          <img
            v-if="album.latestPhoto"
            class="card-img-top colorfondo"
            :src="baseUrl + '/storage/images/photos/' + album.latestPhoto.file_name"
            style="height: 250px"
            alt="Card image cap"
          />
          <img
            v-else
            class="card-img-top"
            :src="baseUrl + '/images/photo.png'"
            style="height: 250px"
          />
          <hr />
          <div class="card-body colorfondo" style="text-align: center">
            <h5 class="card-title">{{ album.title }}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "album-index",
  props: ["app"],
  data() {
    return {
      baseUrl: BASE_URL,
      albums: null,
      loading: false,
      info: null,
      idprimario: null
    };
  },

  mounted() {
    if (this.app.user === null) {
      //this.app.$router.push({name:'auth.login'});

      //  this.app.user  ={ "id": 1, "name": "Carlos Galeano", "email": "cags20031@gmail.com", "email_verified_at": null, "created_at": "2019-10-25 17:03:30", "updated_at": "2019-10-25 17:03:30" }

      this.getAlbums();
    } else {
      this.getAlbums();
    }
  },

  methods: {
    getAlbums() {
      let $this = this;

      this.app.request.get("album").then(response => {
        $this.albums = response.data;
      });
    },

    goToAlbum(album) {
      let $this = this;

      /*  this.app.request.get("album/isSubAlbum/" + album.id).then(response => {
          this.info= response.data;
        
        }); */

      this.app.request
        .get("album/haveIdPrimario/" + album.id)
        .then(response => {
          this.idprimario = response.data.respuesta;
          
          if (this.idprimario === true) {
            this.app.$router.push({
              name: "album.show",
              params: { id: album.id }
            });
          } else {
            this.loading = true;
            // this.app.request.get('album/').then((response) => {
            this.app.request.get("album/id/" + album.id).then(response => {
              this.albums = response.data;
              this.loading = false;
            });
          }

          //console.log(this.idprimario);
        });

      //this.info='test';

      //console.log(this.idprimario.id);
      console.log(this.idprimario);

      //this.app.$router.push({name:'album.show', params: {id: album.id}});
    }
  }
};
</script>

<style scoped>
.album {
  cursor: pointer;
}
.jumbotron {
  background-image: url("/images/logytech_logo_3.png");
  background-size: contain;
  color: #ffffff;
}
.colorfondo {
  ---background-color: #9c9c9c !important;
  color: #828282 !important;
  font-family: "Times New Roman", Times, serif;
  font-size: 17px !important;
}
</style>