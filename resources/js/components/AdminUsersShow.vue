<template>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User #{{ $route.params.id }}</h3>
        </div>
        <!-- /.card-header -->
        
        <div class="card-body">
            <p>User Name: {{ user.name }}</p>
            <p>User Email: {{ user.email }}</p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
</template>

<script>
export default {
    props: ['id'],

    data() {
        return {
            user: ''
        }
    },

    mounted() {
        console.log(this.id)

        axios.get('/api/v1/users/'+this.id).then(response => {
            this.user = response.data
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