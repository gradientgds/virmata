<template>
<div class="col-12">
    <!-- Create User Modal -->
    <div class="modal" ref="createUserModal" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Create New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="createUserForm" role="form" @submit.prevent="createUser">
            <div class="modal-body">
                <p v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="(error, key) in errors" :key="key">{{key }} - {{ error }}</li>
                    </ul>
                </p>
                <div class="form-group">
                    <label for="exampleInputName">User Name</label>
                    <input type="text" class="form-control" v-model="newUser.name" placeholder="John Smith">
                </div>
                <p>{{ newUser.name }}</p>
                <div class="form-group">
                    <label for="exampleInputEmail">User Email</label>
                    <input type="email" class="form-control" v-model="newUser.email" placeholder="john@smith.com">
                </div>
                <p>{{ newUser.email }}</p>
                <div class="form-group">
                    <label for="exampleInputPassword">User Password</label>
                    <input type="password" class="form-control" v-model="newUser.password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" v-model="newUser.password1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" ref="editUserModal" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit User #{{ user.id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form role="form" @submit.prevent="updateUser">
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputName">User Name</label>
                    <input type="text" class="form-control" v-model="user.name" placeholder="John Smith">
                </div>
                <p>{{ user.name }}</p>
                <div class="form-group">
                    <label for="exampleInputEmail">User Email</label>
                    <input type="email" class="form-control" v-model="user.email" placeholder="john@smith.com">
                </div>
                <p>{{ user.email }}</p>
                <div class="form-group">
                    <label for="exampleInputPassword">User Password</label>
                    <input type="password" class="form-control" v-model="user.password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" v-model="user.password1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Show User Modal -->
    <div class="modal" id="showUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Show User #{{ user.id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>User Name: {{ user.name }}</p>
                <p>User Email: {{ user.email }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User List</h3>

            <div class="card-tools">
                <button class="btn btn-success btn-sm" @click="showCreateUserModal">Add New <i class="fa fa-plus fa-fw"></i></button>
            </div>
        </div>
        <!-- /.card-header -->
        
        <div class="card-body">

        <table id="example11" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <!-- <router-link :to="{path: `/admin/users/${user.id}`}"><button class="btn btn-default"><i class="fa fa-eye fa-fw"></i></button></router-link> -->
                        <button class="btn btn-default" @click="showUserModal(user.id)"><i class="fa fa-eye fa-fw"></i></button>
                        <button class="btn btn-default" @click="editUserModal(user.id)"><i class="fa fa-edit fa-fw"></i></button>
                        <button class="btn btn-default" @click="testing"><i class="fa fa-trash fa-fw"></i></button>
                    </td>
                </tr>

            </tbody>
        </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col-12 -->
</template>

<script>
export default {
    data() {
        return {
            users: [],
            user: {},
            newUser: {},
            errors: [],
        }
    },

    mounted() {
        this.fetchUsers()

        $(this.$refs.createUserModal).on("hidden.bs.modal", this.resetCreateUserForm)
    },

    methods: {
        testing(e) {
            console.log(e)
        },

        resetCreateUserForm(e) {

            this.newUser = {}
            this.errors = []
        },

        showCreateUserModal(e) {

            $("#createUserModal").modal('show')
        },

        showUserModal(id) {
            axios.get('/api/v1/users/'+id).then(response => {

                console.log(response)

                this.user = response.data

                $("#showUserModal").modal('show')

            }).catch(error => {
                console.log(error)
            })
        },

        editUserModal(id) {

            axios.get('/api/v1/users/'+id).then(response => {

                console.log(response)

                this.user = response.data

                $("#editUserModal").modal('show')

            }).catch(error => {

                console.log(error)

            })
        },

        validateCreateForm(e) {
            this.errors = [];

            if (!this.newUser.name)
            {
                this.errors.push("Name required.");
            }

            if (!this.newUser.email)
            {
                this.errors.push('Email required.');
            }
            else if (!this.validEmail(this.email))
            {
                this.errors.push('Valid email required.');
            }

            if (!this.errors.length) {
                return true;
            }

            e.preventDefault();
        },

        createUser(e) {

            console.log(this.newUser)

            this.validateCreateForm(e)

            axios.post('/api/v1/users', {

                data: this.newUser,

            }).then(response => {

                console.log(response)

                $("#createUserModal").modal('hide')

                this.fetchUsers()

                this.resetCreateUserForm()

            }).catch(error => {
                console.log(error)
            })
        },

        updateUser(e) {

            console.log(this.user)

            axios.put('/api/v1/users/'+this.user.id, {

                data: this.user,

            }).then(response => {

                console.log(response)

                $("#editUserModal").modal('hide')

                this.fetchUsers()

            }).catch(error => {
                console.log(error)
            })
        },

        fetchUsers() {

            axios.get('/api/v1/users').then(response => {

                console.log(response)

                this.users = response.data

            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>
