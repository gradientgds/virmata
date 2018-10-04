<template>
    <tr>
        <td><button type="button" @click="$emit('remove')" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i></button></td>
        <td>
            <selectize :name="'itemRows['+index+'][item_id]'" :options="options" v-model="item.itemId"></selectize>
        </td>
        <td><input type="number" class="form-control" :name="'itemRows['+index+'][quantity]'" min="1" ref="quantity" v-model.number.lazy.trim="item.quantity"></td>
        <td><input type="number" class="form-control" :name="'itemRows['+index+'][price]'" min="0" ref="price" v-model.number.lazy.trim="item.price"></td>
        <td>{{ totalPrice }}</td>
    </tr>
</template>

<script>
import Selectize from './Selectize.vue'

export default {

    components: {
        Selectize
    },

    props: ['item', 'index', 'options'],

    data()
    {
        return {
            tempItem: {}
        }
    },

    computed: {
        totalPrice: function()
        {
            this.item.total = this.item.quantity * this.item.price
            this.$emit('recalc', this.item)
            return new Intl.NumberFormat('en-ID', { style: 'currency', currency: 'IDR' }).format(this.item.total)
        }
    },

    watch: {
        'item.itemId': function( value )
        {
            this.item.quantity = 1
            this.$refs.price.select()
        }
    },

    methods: {
    },
    
    mounted()
    {
        console.log('InvoiceRow is init.')
    },

    
}
</script>