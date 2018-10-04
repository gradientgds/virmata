<template>
<table id="example1" class="table table-bordered table-hover mt-5">
    <thead>
        <tr>
            <th><button type="button" class="btn btn-sm btn-primary" @click="addRow">Add Row</button></th>
            <th>Vendor Name</th>
            <th>Account Name</th>
            <th>Amount</th>
            <th>Memo</th>
        </tr>
    </thead>

    <tbody>
        <tr is="account-row" v-for="( account, index ) in accountRows" :index="index" :key="account.row" :account="account" @remove="delRow( index )"></tr>
    </tbody>
</table>    
</template>

<script>
import AccountRow from './AccountRow.vue'

export default {
    components: {
        AccountRow,
    },

    data() {
        return {
            rows: 1,
            accountRows: [{
                row: 1,
                vendorId: null,
                accountId: null,
                amount: 0,
                memo: '',
            }],
        }
    },

    methods: {
        addRow()
        {
            this.rows += 1
            this.accountRows.push({
                row: this.rows,
                vendorId: null,
                accountId: null,
                amount: 0,
                memo: '',
            })
        },
        delRow( index )
        {
            this.accountRows.splice(index, 1)

            if (!this.accountRows.length)
            {
                this.addRow()
            }
        },
    },
}
</script>

<style>

</style>
