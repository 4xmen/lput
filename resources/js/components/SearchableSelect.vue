<template>
    <div id="searchable-select">
        <div id="ss-modal" @click.self="hideModal" v-if="modalShow">
            <div id="ss-selector">
                <div class="p-2">
                    <input type="text" class="form-control" v-model="q" :placeholder="xtitle">
                </div>
                <div class="p-2">
                    <ul id="vue-search-list" class="list-group list-group-flush">
                        <template v-for="item in items">
                        <li
                            v-if="(q != '' && item[titleField].toLocaleLowerCase().indexOf(q.toLocaleLowerCase()) != -1) || (q == '')"
                            @click="selecting(item[valueField])"
                            :class="`list-group-item ${val == item[valueField]?'selected':''}`">
                            {{item[titleField]}}
                        </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend" id="vue-search-btn" @click="showModal" >
                <span class="input-group-text" id="basic-addon1">
                    <i class="ri-search-2-line"></i>
                </span>
            </div>
            <select  :id="xid" :class="getClass" v-model="val" @change="select">
                <option value=""> {{xtitle}} </option>
                <option v-for="item in items"
                        :value="item[valueField]"
                        :selected="item[valueField] == val">
                     {{item[titleField]}}
                </option>
            </select>
        </div>
    </div>
    <input type="hidden" :name="xname" :value="val">
</template>

<script>
export default {
    name: "searchable-select",
    components: {},
    data: () => {
        return {
            modalShow: false, // modal handle
            q: '', // search query
            val:'',
        }
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            default: NaN,
        },
        items:{
            required: true,
            default: [],
            type: Array,
        },
        valueField:{
            default: 'id',
            type: String,
        },
        titleField:{
            default: 'title',
            type: String,
        },
        xname:{
            default: "",
            type: String,
        },
        xtitle:{
            default: "Please select",
            type: String,
        },
        xvalue:{
            default: "",
            type: String,
        },
        xid:{
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

        onSelect:{
            default: function () {

            },
            type: Function,
        },
        closeOnSelect: {
            default: false,
            type: Boolean,
        },
    },
    mounted() {
        if (!isNaN(this.modelValue)) {
            this.val = this.modelValue;
        }else{
            this.val = this.xvalue;
        }
    },
    computed: {
        getClass: function () {
            if (this.err == true || ( typeof this.err == 'String' && this.err.trim() == '1' )) {
                return 'form-control is-invalid '+this.customClass;
            }
            return 'form-control '+this.customClass;
        },
    },
    methods: {
        selecting(i){
            this.val = i;
            this.onSelect(this.val);
            if (this.closeOnSelect){
                this.hideModal();
            }
        },
        select(){
            this.onSelect(this.val);
        },
        hideModal:function () {
            this.modalShow = false;
        },
        showModal(){
            this.modalShow = true;
        }
    },
    watch: {
        val(newValue) {
            if (!isNaN(this.modelValue)) {
                this.$emit('update:modelValue', newValue);
            }
        }
    }
}
</script>

<style scoped>
#searchable-select {

}

#vue-search-btn{
    cursor: pointer;
    user-select: none;
}

#vue-search-btn:hover .input-group-text{
    background: deepskyblue;
}


#ss-modal{
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 999;
    background: #00000033;
    backdrop-filter: blur(4px);
    user-select: none;
}

#ss-selector{
    height: 60vh;
    border-radius: 7px;
    min-width: 350px;
    width: 400px;
    max-width: 90%;
    margin: 20vh auto;
    background: #ffffff99;
    padding: 5px;
}

#vue-search-list{
    height: calc(60vh - 90px);
    overflow-x: auto ;
}

#vue-search-list .list-group-item:hover{
    background: deepskyblue;
}
#vue-search-list .list-group-item.selected{
    background: dodgerblue;
    color: white;;
}
</style>
