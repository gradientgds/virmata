<template>
    <table id="example1" class="table table-bordered">
        <thead>
            <tr>
                <th><button type="button" class="btn btn-sm btn-primary" @click="addRow">Add Row</button></th>
                <th v-for="(column, index) in columns" :key="index">{{ column }}</th>
            </tr>
        </thead>

        <tbody>
            <tr is="item-row" v-for="(item, index) in itemRows" :item="item" :index="index" :key="item.row" :options="itemOptions" @remove="delRow(index)" @recalc="recalculate(index, $event)">
            <tr>
                <td colspan="4" style="text-align:right">Subtotal :</td>
                <td><input type="hidden" class="form-control" name="totalRows[sub_total]" v-model.number="subtotal">{{ subtotalText }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right; vertical-align:middle">Discount :</td>
                <td><input type="number" class="form-control" name="totalRows[discount]" v-model.number.lazy="discount"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right">PPN 10% <span v-if="isPpnIncluded">(included)</span></td>
                <td><input type="hidden" class="form-control" name="totalRows[tax_ppn]" v-model.number="ppn">{{ ppnText }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right; vertical-align:middle">Freight :</td>
                <td><input type="number" class="form-control" name="totalRows[freight_income]" v-model.number.lazy="freightIncome"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right">Grand Total :</td>
                <td><input type="hidden" class="form-control" name="totalRows[grand_total]" v-model.number="grandTotal">{{ grandTotalText }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import ItemRow from './ItemRow'

export default {

    components: {
        ItemRow
    },

    props: ['isPpn', 'isPpnIncluded'],

    data() {
        return {
            
            columns: ['Product Name', 'Quantity', 'Price', 'Total Price'],
            rows: 1,
            itemRows: [{
                row: 1,
                itemId: null,
                quantity: 0,
                price: 0,
                total: 0,
            }],
            
            itemOptions: [],

            subtotal: 0,
            discount: 0,
            ppn: 0,
            freightIncome: 0,
            grandTotal: 0,
        }
    },

    computed: {
        subtotalText: function() {
            return this.formatCurrency(this.subtotal)
        },

        grandTotalText: function() {
            return this.formatCurrency(this.grandTotal)
        },

        ppnText: function() {
            return this.formatCurrency(this.ppn)
        },
    },

    watch: {},

    methods: {

        formatCurrency( value )
        {
            return new Intl.NumberFormat('en-ID', { style: 'currency', currency: 'IDR' }).format(value)
        },

        init()
        {
            this.itemOptions = this.initOptions( '/api/v1/items' )
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

        addRow()
        {
            this.rows += 1;
            this.itemRows.push({
                row: this.rows,
                itemId: null,
                quantity: 0,
                price: 0,
                total: 0,
            });
        },

        delRow( index )
        {
            this.itemRows.splice(index, 1)
        },

        recalculate( index, itemRow )
        {
            let subtotal = 0
            let ppn = 0

            this.itemRows[index] = itemRow

            for (let row of this.itemRows)
            {
                subtotal += row.total
            }

            this.subtotal = subtotal

            if (this.isPpn)
            {
                if (this.isPpnIncluded)
                {
                    this.ppn = (this.subtotal - this.discount) / 11
                }
                else
                {
                    this.ppn = (this.subtotal - this.discount) / 10
                    ppn = this.ppn
                }
            }
            else
            {
                this.ppn = 0
            }
            
            this.grandTotal = subtotal - this.discount + ppn + this.freightIncome;
        },
    },

    mounted() {
        this.init()
    }
}
</script>

<style>

</style>
