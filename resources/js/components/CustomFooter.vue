<template>
    <div class="footer-copyright text-center " id="footer-zone" >
        <div class="row"  >
        <div class="col-md-6  pull-right">
            Desarrollado por <strong><a href="#" target="_blank">Logytech</a></strong>.
        </div>
        <div  class="col-md-6" >
            <strong>Derechos Reservados</strong> Logytech © {{year}}
        </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: "CustomFooter",

        data() {
            return {
                year: moment().format('YYYY')
            };
        },
    }
</script>

<style scoped>
#footer-zone { 
  height: 50px; 
  background:write; 
  width:100%; 
  position:relative ; 
  bottom:0; 
  left:0; 
}
</style>