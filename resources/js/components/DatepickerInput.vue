<template>
    <input :name="name" type="text" class="form-control" v-model="date">
</template>

<script>
export default {

    props: ['name', 'value'],

    data() {
        return {
            date: '',
        }
    },

    methods: {
    },

    mounted() {
        console.log('DatePickerInput is mounted.')

        let vm = this
        let input = $(this.$el)

        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth()+1;
        let yyyy = today.getFullYear();

        if (dd < 10)
        {
            dd = '0'+dd
        }

        if (mm < 10)
        {
            mm = '0'+mm
        }

        if ( ! this.value || this.value == undefined )
        {
            this.date = dd + '-'+ mm +'-'+ yyyy;
        }
        else
        {
            this.date = this.value;
        }

        input
            .datepicker({
                dateFormat: 'dd-mm-yy',
            })
    },
    
    watch: {
    },

    destroyed() {
    },
}
</script>
