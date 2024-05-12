<template>
    <div id="date">
        <input @keyup="keyup" :id="idd" :placeholder="ptitle" :class="getClass" type="text" v-model="val" >
        <input type="hidden" :name="pname" :value="noComma">
    </div>
</template>

<script>

function commafy( num ) {
    if (typeof  num !== 'string'){
        return '';
    }
    let str = uncommafy(num.toString()).split('.');
    if (str[0].length >= 5) {
        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    if (str[1] && str[1].length >= 5) {
        str[1] = str[1].replace(/(\d{3})/g, '$1 ');
    }
    return str.join('.');
}

function  uncommafy(txt){
    return txt.split(',').join('');
}
export default {
    name: "curency-input",
    components: {},
    data: () => {
        return {
            val:'',
        }
    },
    props:{
        pname:{
            default: "",
            type: String,
        },
        ptitle:{
            default: "",
            type: String,
        },
        pvalue:{
            default: "",
            type: String,
        },
        idd:{
            default: "",
            type: String,
        },
        customClass:{
            default: "",
            type: String,
        },
        err:{
            default: false,
            type: Boolean,
        },

        updateKey:{
            default: function () {

            },
            type: Function,
        },

    },
    mounted() {
        if (typeof this.pvalue == 'number'){
            this.val = commafy(this.pvalue.toString());
        }else{

            this.val = commafy(this.pvalue);
        }
    },
    computed: {
        noComma:function () {
          return uncommafy(this.val);
        },
        getClass: function () {
            if (this.err == true || ( typeof this.err == 'String' && this.err.trim() == '1' )) {
                return 'form-control is-invalid';
            }
            return 'form-control ';
        }
    },
    methods: {
        keyup:function () {
            this.val = commafy(this.val);
            if (typeof this.update === 'function' ){
                this.update(this.updateKey,parseInt(this.noComma));
            }
        },
    }
}
</script>

<style scoped>
#date {

}
</style>
