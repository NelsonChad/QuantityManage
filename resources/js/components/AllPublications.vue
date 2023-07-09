<template>
    <div>
        <div class="row">
            <div class="col-5" >
                <h2>Dados de Produção Mensal ({{ currentYear }})</h2>
            </div>
            <div v-for="(year, key) in years" :key="key" class="col-1">
                <button type="button" 
                    class="btn btn-f" 
                    :style="{'background-color': activeButton === key ? this.bcolor : '#5C636A'}"
                    @click="chengeYear(year, key)">
                    {{ year.year }}
                </button>
            </div>
        </div>
        <hr>

        <div style="height: 20px;"></div>
        <div class="d-flex flex-wrap justify-content-center" v-if="this.loading">
            Carregando Publicações <pulse-loader :loading="this.loading" ></pulse-loader>
        </div>
        <div v-for="(product, key) in productsCompanies" :key="key">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th width="200" class="thProd">{{product.name}} ({{product.unity}})</th>
                        <th class="thYear">Total Anual {{product.created_at}}</th>
                        <th class="thFor" v-for="(month, key) in months" :key="key" :class="{ filled: isAllColumnsFilled && isColumnFilled(month.month) }">  
                            <div class="months">{{month.month}}</div>
                        </th>
                        <!--th class="text-center" colspan="3" style="width:15%">Acções</th-->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(companies, key) in product.users" :key="key">
                        <td>{{companies.name }}</td>
                        <td><b>{{ companies.total_qtd }}</b></td>
                        <td v-for="(pubs, key) in companies.publications" :key="key"> 
                            <b>{{ pubs.quantity }}</b>
                        </td>      
                    </tr>
                    <tr>
                        <td class="totals"><b>Total</b></td>
                        <td class="totals"><b>{{ product.perYearsTotal }}</b></td>
                        <td class="totals" v-for="(total, key) in product.total_per_moths[0]" :key="key"> 
                            <b v-if="total != 0">{{ total  }}</b>
                        </td> 
                    </tr>
                </tbody>
            </table>
        </div>
        

    </div>
</template>
<script>
import api from '../api';
import PulseLoader from "vue-spinner/src/PulseLoader.vue"; //https://www.npmjs.com/package/vue-spinner
import Swal from 'sweetalert2' //https://sweetalert2.github.io/#usage

//const currentDate = new Date();
export default {
      components: {
        PulseLoader,
        Swal
      },
      mounted() {
        this.getYear()
      },
      data() {
        return {
          activeButton: 0,
          bcolor: "#039BE5",
          loading: false,
          productsCompanies: [],
          months: [],
          rows: [],
          totalPerMonths: [],
          //currentYear: currentDate.getFullYear(),
          currentYear: '2023',
          years : []
        }
      },
      computed: {
        isAllColumnsFilled() {
            const headerColumns = this.months.map(month => month.month);
            const dataColumns = this.productsCompanies.flatMap(company => {
            return company.users.flatMap(user => {
                return user.publications.map(pub => {
                return pub.month;
                });
            });
            });

            const uniqueColumns = [...new Set([...headerColumns, ...dataColumns])];
            return uniqueColumns.every(column => dataColumns.includes(column));
        }
      },
      methods: {
        chengeYear(year, index){
            this.activeButton = index;
            this.bcolor = '#039BE5';
            this.year = year
            this.currentYear = year.year;
            this.getMonths(year.id);
            this.getPublications(year.id)
        },
        getMonths(year){
            console.log("USER ID: ", this.user_id)
            this.loading = true;
            api.get('/api/get-months/'+ this.user_id+'/'+year)
            .then((response)=>{
                this.loading = false;
                this.months = response.data.months;
            });
        },
        getYear(){
            this.loading = true;
            api.get('/api/get-years')
            .then((response)=>{
                this.loading = false;
                this.years = response.data.years;
                this.year = this.years[0]
                this.getMonths(this.year.id)
                this.getPublications()
                console.log("SELECTED YEAR: "+ this.year.year)

            });
        },
        getPublications(){
            this.loading = true;
            var total_year = 0;

            api.get('/api/get-allpublications')
            .then((response)=>{
                this.loading = false;
                this.productsCompanies = response.data.publications
                this.productsCompanies.forEach((async product =>{
                    product.perYearsTotal = 0
                    var yearsTotal = 0;
                    product.total_per_moths = []

                    product.users.forEach((async (user, j) =>{
                        var total_year = 0;
                        user.publications = []
                        user.total_qtd = 0
                        await this.getEachPublication(user.id, product.id)
                        .then((response)=>{

                            response.forEach((async (pub, index)  =>{
                                if( user.id == pub.user_id){
                                    total_year += parseInt(pub.quantity)

                                    user.publications.push(pub)
                                    user.total_qtd = total_year // total per year
                                }
                                yearsTotal +=  response[index].quantity // all total of year 
                            }));
                        })
                        product.perYearsTotal = yearsTotal // to see
                        //console.log("ARRAY 2 "+tpm)
                      
                    }));
                    var tpm = await this.getTotalProducPerMonth(product.id)
                        await product.total_per_moths.push(JSON.parse(tpm))  
                }));
            });
        },
        async getEachPublication(user_id, product_id){
            var response = await api.get('/api/get-publications/'+user_id+"/"+product_id+"/"+this.year.id);
            //console.log("PUB PER PRODUCT: " + JSON.stringify(response.data.publicationsProduct)) 
 
            return response.data.publicationsProduct;
        },
        async getTotalProducPerMonth(product_id){
            console.log('PRODUCT/'+product_id+"/"+this.year.id)

            var response = await api.get('/api/total-months/'+product_id+"/"+this.year.id);
            var total = response.data.total_moths;
            //console.log("ARRAY 1 "+JSON.stringify(total) )
           
            return JSON.stringify(total);
        },
        showAlert(title, text, more, type){
            Swal.fire({
            title: title,
            text: `${text}\n${more}`,
            icon: type,
            confirmButtonText: 'OK'
            })
        }
      },
       
    }
</script>
<style scoped>
    th {
        text-align: center;
        vertical-align: middle;
    }

    .totals {
        background-color: #e6eaee;
    }
    .filled {
        background-color: yellow;
    }
    .thFor{
        background-color: #5c636a;
        color: #ffff;
    }
    .thYear {
        background-color: #c9caca;

    }
    .thProd{
        background-color: #e6eaee;
    }
    .btn-f{
        color: white;
    }
    .spn {
        width: 70px;
    }
    .month {
        color: blue;
    }
    .title {
        font-weight: bold; 
    }
    .values {
        background-color: azure;
    }
</style>