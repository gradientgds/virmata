<template>

<form role="form" method="POST" action="/admin/sales/orders" @submit.prevent="validateForm">

    <div class="card-body">

        <div class="row">
            <div class="form-group col">
                <label for="date">Date</label>
                <datepicker-input name="date"></datepicker-input>
            </div>
            <div class="form-group col">
                <label>Seller</label>
                <selectize name="seller_id" :options="sellerOptions"></selectize>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label>Customer</label>
                <selectize name="customer_id" :options="customerOptions"></selectize>
            </div>
            <div class="form-group col">
                <label>Shipping Service</label>
                <selectize name="shipping_service_id" :options="shippingServiceOptions"></selectize>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label>Marketplace</label>
                <selectize name="marketplace_id" :options="marketplaceOptions"></selectize>
            </div>
            <div class="form-group col">
                <label>Reference Number</label>
                <input type="text" class="form-control" name="reference_number" value="">
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description"></textarea>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <input type="checkbox" id="ppn" name="ppn" v-model="isPpn">
                <label for="ppn">PPN</label>
            </div>

            <div class="checkbox">
                <input type="checkbox" id="ppn_included" name="ppn_included" v-model="isPpnIncluded" :disabled="!isPpn" >
                <label for="ppn_included">PPN Included</label>
            </div>
        </div>

        <item-table :isPpn="isPpn" :isPpnIncluded="isPpnIncluded"></item-table>
        
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
    <!-- /.card-footer -->

</form>
<!-- /form -->

</template>

<script>
import Selectize from './Selectize'
import ItemTable from './ItemTable'

export default {

    components: {
        Selectize,
        ItemTable,
    },

    props: {
        // type: String,
    },

    data: function() {
        return {
            
            customerOptions: [],
            sellerOptions: [],
            shippingServiceOptions: [],
            marketplaceOptions: [],
            
            isPpn: false,
            isPpnIncluded: false,

            error: [],
        }
    },

    computed: {
    },

    watch: {
        isPpn: function( val ) {
            if ( val == false )
            {
                this.isPpnIncluded = false
            }
        }
    },

    methods: {
        
        validateForm( event )
        {
            if (this.subtotal == 0)
            {
                console.log('error - subtotal is 0')
            }
            else
            {
                event.target.submit()
            }
        },

        init()
        {
            this.customerOptions = this.initOptions( '/api/v1/customers' )
            this.sellerOptions = this.initOptions( '/api/v1/users' )
            this.shippingServiceOptions = this.initOptions( '/api/v1/shipping-services' )
            this.marketplaceOptions = this.initOptions( '/api/v1/marketplaces' )
        },

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
        console.log('TestComponent is init.')
        this.init()
    },
}
</script>
