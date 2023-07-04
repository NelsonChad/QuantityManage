<template>
    <!-- The Modal -->
    <div id="form-modal" class="modal-dialog-container">
      <div class="modal-dialog-content">
        <div class="modal-dialog-header">
          <h4>Registar para o mês de {{ this.month.month }}</h4>
        </div>
        <div class="modal-dialog-body">
          <form @submit.prevent="savePub">
            <div class="form-group" v-for="(product, index) in this.products" :key="index">
              <label for="product-name">{{product.name}}</label>
              <input required type="number" class="form-control" id="product-name" :placeholder="'Introduza a quantidade de '+  product.name + ' em '+product.unity" v-model="product.quantity">
            </div>
            <br>
            <div v-if="!this.loading" class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Cancelar</button>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
              <pulse-loader :loading="this.loading" ></pulse-loader>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
    import axios from 'axios';
    import PulseLoader from "vue-spinner/src/PulseLoader.vue"; //https://www.npmjs.com/package/vue-spinner
    import Swal from 'sweetalert2' //https://sweetalert2.github.io/#usage

    export default {
      components: {
        PulseLoader,
        Swal
      },
      props: {
        products: Object,
        month: Object,
        user_id: Number,
      },
      data() {
        return {
          loading: false,
          product: this.parentProduct,
          publications: []
        }
      },
      computed: {
       
      },
      methods: {
        chengeYear(year){
            this.currentYear = year;
        },
        closeModal() {
            console.log("Closing")
            this.$emit('close-modal-event');
        },
        savePub() {
          //'quantity', 'month_id', 'product_id', 'company_id', 'user_id',
          this.loading = true;
     
          this.products.forEach((prod) => {
            console.log(prod.quantity +" "+prod.id);
            var body = {
              quantity: prod.quantity,
              month_id: this.month.id,
              product_id: prod.id,
              company_id: 1
            };

            this.publications.push(body)
            
          });

          console.log("LL: "+ JSON.stringify(this.publications))
          axios.post('http://localhost/companymanage/public/api/store-publication/'+this.user_id, this.publications)
            .then((response)=>{
                this.loading = false;

                console.log("RESP: " + JSON.stringify(response.data) )
                var message = response.data.message;
                if(response.data.status){
                    this.showAlert("Confirmado", message,"",'success');
                    this.closeModal()
                } else {
                    var err = response.data.error;
                    this.showAlert("Erro", message, err, 'error');
                }
                this.publications = [];
            });

        },
        showAlert(title, text, more, type){
            Swal.fire({
            title: title,
            text: `${text}\n${more}`,
            icon: type,
            confirmButtonText: 'OK'
            })
        }
      }
    }
  </script>
  
  <style scoped>
    .modal-dialog-container {
      /* display: none; Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1;
      /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
    }
  
    .modal-dialog-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      border-radius: 0.3rem;
      width: 30%;
    }
  
    .btn-close {
      margin-left: 0.5rem;
    }
  </style>