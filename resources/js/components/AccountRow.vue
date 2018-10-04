<template>
    <tr>
        <td><button type="button" @click="$emit('remove')" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i></button></td>
        <td>
            <selectize :name="'accountRows['+index+'][vendor_id]'" :options="vendorOptions" v-model="account.vendorId"></selectize>
        </td>
        <td>
            <selectize :name="'accountRows['+index+'][account_id]'" :options="accountOptions" v-model="account.accountId"></selectize>
        </td>
        <td><input type="number" class="form-control" :name="'accountRows['+index+'][amount]'" v-model="account.amount"></td>
        <td><input type="text" class="form-control" :name="'accountRows['+index+'][memo]'" v-model="account.memo"></td>
    </tr>
</template>

<script>
import Selectize from './Selectize.vue'

export default {

    components: {
        Selectize
    },

    // props: {
    //     item: Object,
    //     index: Number,
    //     options: Array,
    // },

    props: ['index', 'account'],

    data()
    {
        return {
            // quantity: 0,
            // price: 0,
            vendorOptions: [],
            accountOptions: [],
        }
    },

    computed: {
    },

    watch: {
    },

    methods: {
        initOptions( uri )
        {
            let tempArr = []

            axios.get(uri).then(response => {
            
                response.data.forEach(element => {

                    tempArr.push({
                        value: element.id,
                        text: element.name,
                    })
                });

            }).catch(error => {
                console.log(error)
            })

            return tempArr
        },
    },
    
    mounted()
    {
        console.log('AccountRow is init.')
        this.vendorOptions = this.initOptions( '/api/v1/vendors' )
        this.accountOptions = this.initOptions( '/api/v1/accounts' )
    },

    
}
</script>