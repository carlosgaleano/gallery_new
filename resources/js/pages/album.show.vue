<template>
    <div class="container">
        <spinner class="bigSpinner"
                 size="massive"
                 line-fg-color="#4CAF50"
                 v-if="loading"
                 message="Loading...">
        </spinner>
        <div v-else-if="album">
            <div class="jumbotron" v-if="app.user" style="text-align: center">
                <h1 class="display-4"><!-- {{ album.title }} --></h1>
               <!--  {{ this.albumId }} -->
            </div>

            <div class="card" v-bind:style="{ 'border-bottom': album.photos.length ? '1px': '0' }">
                <div class="card-header colorfondo"  >
                    {{ album.title }}
                    <router-link   v-if="app.user"  :to="{ name: 'photo.create', params: { albumId: album.id } }" class="float-right">Upload Photo</router-link>
                </div>
            </div>

            <div class="row" v-if="album.photos.length > 0" style="margin-top: 25px">
                <div class="col-md-3"  v-for="(photo, index) in album.photos" v-bind:key="index">
                    <div class="card photo" @click="showPhoto(photo)">
                        <img class="card-img-top"
                             :src="baseUrl + '/storage/images/photos/' + photo.file_name"
                             style="height: 250px" />
                        <div class="card-body  colorfondo" style="text-align: center" v-if="photo.desc">
                            <h5 class="card-title">{{ photo.desc }}</h5>
                        </div>
                    </div>
                </div>

            </div>
            <div v-else class="alert alert-secondary" role="alert" style="margin-top: 20px">
                No photos exist.
            </div>


            <photo-big id="photo-big" :app="app" :photo="currentPhoto"></photo-big>
        </div>
    </div>
</template>

<script>
    import PhotoBig from "../components/photo.big";
    export default {
        name: "album-show",
        components: {PhotoBig},
        props: ['app'],
        data()
        {
            return {
                albumId: this.app.$route.params.id,
                album: null,
                loading: false,
                currentPhoto: null,
                baseUrl: BASE_URL
            }
        },

        mounted()
        {
            if (this.app.user === null)
            {
             //   this.app.$router.push({name:'auth.login'});
              //this.app.user  ={ "id": 1, "name": "Carlos Galeano", "email": "cags20031@gmail.com", "email_verified_at": null, "created_at": "2019-10-25 17:03:30", "updated_at": "2019-10-25 17:03:30" }
               this.loadAlbum();

               console.log('mostrar albums');
            }
            else
            {
                this.loadAlbum();

                 console.log('mostrar albums2');
            }

        },

        methods: {
            showPhoto(photo)
            {
                this.currentPhoto = photo;

                $('#photo-big').modal('show');
            },

            loadAlbum()
            {


                this.loading = true;


                this.app.request.get('album/'+this.albumId).then((response) => {
                    this.album = response.data;
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>
    .photo {
        cursor: pointer;
        margin-bottom: 25px;
    }
    .jumbotron {
     background-image: url('/images/logytech_logo_3.png');
     background-size: contain;
     color: #FFFFFF;
}
.colorfondo{
background-color: #9c9c9c !important;

}
</style>