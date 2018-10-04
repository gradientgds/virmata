<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form role="form" method="POST" v-on:submit.prevent="testing()">
        
        <div class="card-body">

            <div class="form-group">
                <label for="date">Name</label>
                <input type="text" class="form-control" id="name" v-model="name">
                <p>{{ name }}</p>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
        <!-- form end -->
    </div>
    <!-- /.card -->
</template>

<script>
export default {
    props: ['someId'],

    data() {
        return {
            name: ''
        }
    },

    mounted() {
        console.log(this.someId),

        axios.get('/test').then(response => {
            var user = response.data
            this.name = user.name
        }).catch(error => {
            console.log(error)
        })
    },

    methods: {
        testing() {
            alert(123)
        }
    }
}
</script>
