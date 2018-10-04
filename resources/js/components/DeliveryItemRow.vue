<template>
    <tr>
        <td>
            <input type="hidden" name="itemRows[][item_id]]" value="">
        </td>
        <td>Delivered:  |  Not Delivered:  / </td>
        <td>
            <input type="checkbox" name="itemRows[][deliver_all]" value="1">
        </td>
        <td>
            <input type="number" class="form-control" name="itemRows[][quantity]" min="0" max="{{ $itemEntry->quantity_processing }}">
            <input type="hidden" name="itemRows[][from_id]]" value="">
            <input type="hidden" name="itemRows[][from_type]]" value="Admin\Sales\SalesOrderItem">
        </td>
    </tr>
</template>

<script>
export default {

    props: {

    },

    data() {
        return()
        {
    
        }
    },

    computed: {

    },
    
    watch: {

    },

    method: {
        
    },

    mounted()
    {

    },
    
}
</script>

<style>

</style>
