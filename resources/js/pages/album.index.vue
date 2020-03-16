<template>
    <div class="container">
        <div class="jumbotron" style="text-align: center">
            <h1 class="display-4">Albums</h1>
         
            {{info}}
            {{albums}}
           
        </div>

        <spinner class="bigSpinner"
                 size="massive"
                 line-fg-color="#4CAF50"
                 v-if="loading"
                 message="Loading...">
        </spinner>
        <div class="row" v-else>
            <div class="col-md-3" v-for="(album, index) in albums" v-bind:key="index">
                <div class="card album" @click="goToAlbum(album)">
                    <img v-if="album.latestPhoto"
                         class="card-img-top"
                         :src="baseUrl + '/storage/images/photos/' + album.latestPhoto.file_name"
                         style="height: 250px"
                         alt="Card image cap">
                    <img v-else class="card-img-top" :src="baseUrl + '/images/photo.png'" style="height: 250px" />
                    <hr />
                    <div class="card-body" style="text-align: center">
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
        props: ['app'],
        data()
        {
            return {
                baseUrl: BASE_URL,
                albums: null,
                loading: false,
                info: null,
                
            }
        },
        mounted()
        {
            if (this.app.user === null)
            {
                //this.app.$router.push({name:'auth.login'});

          //  this.app.user  ={ "id": 1, "name": "Carlos Galeano", "email": "cags20031@gmail.com", "email_verified_at": null, "created_at": "2019-10-25 17:03:30", "updated_at": "2019-10-25 17:03:30" }

              this.getAlbums();
            }
            else
            {
                this.getAlbums();

            }

        },

        methods: {
            getAlbums()
            {
                let $this = this;


                this.app.request.get('album').then((response) => {
                    $this.albums = response.data;
                })
            },

            goToAlbum(album)
            {

               // let $this = this;
               // this.info='prueba';

                // this.app.request.get('album/').then((response) => {
                    this.app.request.get('album/isSubAlbum/' + album.id).then((response) => {
                    this.albums = response.data;
                   // this.loading = false;
                }) 
                if(this.info == ''){
                    this.app.$router.push({name:'album.show', params: {id: album.id}});
                }else{
                     $this.albums =this.info;

                }
               // this.app.$router.push({name:'album.show', params: {id: album.id}});
            }
        }
    }
</script>

<style scoped>
    .album {
        cursor: pointer;

    }
</style>