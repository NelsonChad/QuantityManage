<template>
    <!-- The Modal -->
    <div id="form-modal" class="modal-dialog-container">
      <div class="modal-dialog-content">
        <div class="modal-dialog-header">
          <h4>{{ modalTitle }}</h4>
        </div>
        <div class="modal-dialog-body">
          <form @submit.prevent="saveProduct">
            <div class="form-group">
              <label for="product-name">Name</label>
              <input type="text" class="form-control" id="product-name" v-model="product.name">
            </div>
            <div class="form-group">
              <label for="product-description">Description</label>
              <input type="text" class="form-control" id="product-description" v-model="product.description">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
    export default {
      props: {
        parentProduct: {
          type: Object,
          required: true
        }
      },
      data() {
        return {
          product: this.parentProduct
        }
      },
      computed: {
        modalTitle() {
           return this.product.id === 0 ? 'Add Product' : 'Edit Product';
        }
      },
      methods: {
        closeModal() {
            console.log("Closing")
            this.$emit('close-modal-event');
        },
        saveProduct() {
          // Add product
          if (this.product.id === 0) {
            this.product.id = 2;
          }
          this.$emit('save-product-event', this.product);
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