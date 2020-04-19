<template>
<div class="container">
    <div class="card">
        <div class="card-header"><h3> Price Predictor </h3></div>
        <br>
        <form @submit.prevent="submit"  class="form-horizontal" id="url_form" method="POST">
            <div class="card-body">
                <div class="form-group row" v-if="state === 0">
                    <label class="col-sm-4 control-label">AirBnB URL:</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" name="url" id="url" v-model="fields.url">
                    <div v-if="errors && errors.url" class="text-danger">{{errors.building[0] }}</div>
                    </div>
                </div>
                <div class="form-group row" v-if="state === 0">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary float-right">
                            Submit
                        </button>
                    </div>
                </div>
                <center v-if="state === 1">
                    <pulse-loader :color="color"></pulse-loader>
                    <strong>Obtaining Room Info</strong>
                </center>
                <div class="form-group row" v-if="state === 2">
                    <label class="col-sm-4 control-label">Listing Name:</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" name="name" id="name" v-model="room_data.name">
                    <div v-if="errors && errors.url" class="text-danger">{{errors.building[0] }}</div>
                    </div>
                </div>
                <div class="form-group row" v-if="state === 2">
                    <label class="col-sm-4 control-label">Location:</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" name="location" id="location" v-model="room_data.location">
                    <div v-if="errors && errors.url" class="text-danger">{{errors.building[0] }}</div>
                    </div>
                </div>
                <div class="form-group row" v-if="state === 2">
                    <label class="col-sm-4 control-label">Type:</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" name="type" id="type" v-model="room_data.room_type">
                    <div v-if="errors && errors.url" class="text-danger">{{errors.building[0] }}</div>
                    </div>
                </div>
                <div class="form-group row" v-if="state === 2">
                    <label class="col-sm-4 control-label">Price:</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" name="price" id="price" v-model="room_data.price">
                    <div v-if="errors && errors.url" class="text-danger">{{errors.building[0] }}</div>
                    </div>
                </div>
                <center v-if="state === 3">
                    <pulse-loader :color="color"></pulse-loader>
                    <strong>Evaluating this rate</strong>
                </center>
                <section class="pricing py-5" v-if="state === 4">
                   <div class="row">
                      <div class="col-lg-3">
                      </div>
                      <div class="col-lg-6">
                         <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                               <h5 class="card-title text-muted text-uppercase text-center">Our estimated price:</h5>
                               <h6 class="card-price text-center">$ {{ this.price_estimate }}<span class="period">/night</span></h6>
                               <hr>
                               <h5 class="card-title text-muted text-uppercase text-center">Current price:</h5>
                               <h6 class="card-price text-center">$ 50.00 <span class="period">/night</span></h6>
                                <div>
      <vue-speedometer 
      :width="500"
      :needleHeightRatio="0.7"
      :value="777"
      currentValueText="FairBnB Dealmeter"
      :customSegmentLabels='[
        {
          text: "Very Bad",
          position: "INSIDE",
          color: "#555",
        },
        {
          text: "Bad",
          position: "INSIDE",
          color: "#555",
        },
        {
          text: "Ok",
          position: "INSIDE",
          color: "#555",
          fontSize: "19px",
        },
        {
          text: "Good",
          position: "INSIDE",
          color: "#555",
        },
        {
          text: "Very Good",
          position: "INSIDE",
          color: "#555",
        },
      ]'
      :ringWidth="47"
      :needleTransitionDuration="3333"
      needleTransition="easeElastic"
      needleColor="#a7ff83"
      textColor="#d8dee9"
    />
    </div>
                               <ul class="fa-ul">
                                  <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>This is a good deal!</strong></li>
                                  <li><span class="fa-li"><i class="fas fa-check"></i></span>You should book now</li>
                               </ul>
                               <a v-bind:href=this.url class="btn btn-block btn-primary text-uppercase">Book on airbnb.com</a>
                            </div>
                         </div>
                         <div class="col-lg-3">
                         </div>
                      </div>
                   </div>
                </section>
                


                <div class="form-group row" v-if="state === 2">
                    <div class="col-sm-12">
                        <button class="btn btn-primary float-right" v-on:click="calculate">
                            Evaluate this rate
                        </button>
                    </div>
                </div>
            </div> 
        </form>
    </div>
</div>
</template>

<style>

.pricing .card {
  border: none;
  border-radius: 1rem;
  transition: all 0.2s;
  box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
}

.pricing hr {
  margin: 1.5rem 0;
}

.pricing .card-title {
  margin: 0.5rem 0;
  font-size: 0.9rem;
  letter-spacing: .1rem;
  font-weight: bold;
}

.pricing .card-price {
  font-size: 3rem;
  margin: 0;
}

.pricing .card-price .period {
  font-size: 0.8rem;
}

.pricing ul li {
  margin-bottom: 1rem;
}

.pricing .text-muted {
  opacity: 0.7;
}

.pricing .btn {
  font-size: 80%;
  border-radius: 5rem;
  letter-spacing: .1rem;
  font-weight: bold;
  padding: 1rem;
  opacity: 0.7;
  transition: all 0.2s;
}

/* Hover Effects on Card */

@media (min-width: 992px) {
  .pricing .card:hover {
    margin-top: -.25rem;
    margin-bottom: .25rem;
    box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.3);
  }
  .pricing .card:hover .btn {
    opacity: 1;
  }
}

</style>

<script>

    export default {
        data () {

        return {
            fields: {},
            errors: {},
            url: '',
            rooom_data: {},
            price_estimate: 0,
            original_price: 0,
            color: '#428bca',
            state: 0,
            loaded: true,
            window: {
                width: 1300,
                height: 1300
            },
            page: 1
        };
    },

    created() {
        window.addEventListener('resize', this.handleResize)
        this.handleResize();
    },

    destroyed() {
        window.removeEventListener('resize', this.handleResize);
    },

    methods: {

        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.state = 1
                this.errors = {};
                this.url = this.fields.url;
                this.original_price = this.fields.price;
                console.log(JSON.stringify(this.fields));
                axios.post('/airbnb_url', {
                        url: this.fields.url,
                    }).then(response => {
                    // console.log(JSON.stringify(response.data))  
                    this.state = 2;  
                    this.room_data = response.data;
                    console.log(this.room_data);
                    this.loaded = true;
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },

        calculate() {
            this.state = 3;
            axios.post('/pred_model', {
                        name: this.room_data.name,
                        location: this.room_data.location,
                        room_type: this.room_data.room_type,
                        price: this.room_data.price
                    }).then(response => {
                    // console.log(JSON.stringify(response.data))  
                    this.state = 4;  
                    this.fields = {}; //Clear input fields.
                    this.price_estimate = response.data.estimated_price.toFixed(2);
                    console.log(this.model_response);
                    this.loaded = true;
                    console.log(this.url);
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
        },

        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },
    }
    }
</script>