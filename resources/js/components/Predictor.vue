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

<script>
    export default {
        data () {

        return {
            fields: {},
            errors: {},
            rooom_data: {},
            model_response: {},
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
                console.log(JSON.stringify(this.fields));
                axios.post('/airbnb_url', {
                        url: this.fields.url,
                    }).then(response => {
                    // console.log(JSON.stringify(response.data))  
                    this.state = 2;  
                    this.fields = {}; //Clear input fields.
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
            this.state += 1;
            axios.post('/pred_model', {
                        name: this.room_data.name,
                        location: this.room_data.location,
                        room_type: this.room_data.room_type,
                        price: this.room_data.price
                    }).then(response => {
                    // console.log(JSON.stringify(response.data))  
                    this.state = 5;  
                    this.fields = {}; //Clear input fields.
                    this.model_response = response.data;
                    console.log(this.model_response);
                    this.loaded = true;
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