<template>
    <select :name="name"></select>
</template>

<script>
export default {

    props: {
        name: String,
        options: {
            type: Array,
        },
        value: String,
        multiple: {
            type: Boolean,
            default: false,
        }
    },

    data()
    {
        return {
        }
    },

    watch: {
        options: function ( options )
        {
            this.init( options )
        }
    },

    methods: {
        init( options ) {

            let vm = this;
            let selectize = $(this.$el).selectize({
                maxItems: 1,
                onChange: function( value )
                {
                    vm.$emit('input', value);
                }
            })[0].selectize;

            selectize.addOption( options );
            selectize.setValue( this.value )
        }
    },

    mounted()
    {
        console.log('Select2 is init.');
        this.init( this.options );
    },
}
</script>

<style>
    .selectize-control.single .selectize-input.input-active {
        border-color: #a1cbef;
        box-shadow: inset 0 0 0 rgba(0, 0, 0, 0), 0 0 0 0.2rem rgba(52, 144, 220, 0.25);
    }
</style>