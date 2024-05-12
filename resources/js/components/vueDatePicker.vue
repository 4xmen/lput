<template>
    <div id="vue-datepicker" >

        <div id="dp-modal" @click.self="modalShow = false" v-if="modalShow">
            <div id="picker">
                <div class="equal-width" id="vuejs-tabs">
                    <div :class="tabIndex == 0?'active-tab':''" @click="tabIndex = 0;">
                        {{ pTitle }}
                    </div>
                    <div :class="tabIndex == 1?'active-tab':''" @click="tabIndex = 1;">
                        {{ gTitle }}
                    </div>
                </div>
                <div class="equal-width" v-if="pDate !== null">
                    <div @click="next" class="vuejsbtn">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>
                    <div @click="monthPick">
                        <span v-if="tabIndex == 0">
                            {{ pMonths[parseInt(peDate[1]) - 1] }}
                        </span>
                        <span v-if="tabIndex == 1">
                            {{ gMonths[geDate[1]] }}
                        </span>
                    </div>
                    <div @click="yearPick">
                        <span v-if="tabIndex == 0">
                            {{ pDate.parseHindi(peDate[0]) }}
                        </span>
                        <span v-if="tabIndex == 1">
                            {{ geDate[0] }}
                        </span>
                    </div>
                    <div @click="previous" class="vuejsbtn">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                </div>
                <div id="calendar-container">
                    <div class="sub-picker" v-if="yPicker" dir="rtl">
                        <div class="equal-width month-list" v-for="j in 5">
                            <template v-for="i in 5">
                                <template v-if="i == 1 && j == 1">
                                    <div @click="startYear -= 23">
                                        <i class="ri-arrow-right-s-line"></i>
                                    </div>
                                </template>
                                <template v-else-if="i == 5 && j == 5">
                                    <div @click="startYear += 23">
                                        <i class="ri-arrow-left-s-line"></i>
                                    </div>
                                </template>
                                <div v-else class="year" @click="yearPicking( (startYear - 13) + ( i + ((j - 1)*5)) )">
                                    {{ (startYear - 13) + (i + ((j - 1) * 5)) }}
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="sub-picker" v-if="pmPicker" dir="rtl">
                        <div class="equal-width month-list" v-for="(ms,j) in chunkArray(pMonths,3)">
                            <div v-for="(m,i) in ms" class="month" @click="pMonthPicking((i + (j * 3)))">
                                {{ m }}
                            </div>
                        </div>
                    </div>
                    <div class="sub-picker" v-if="gmPicker">
                        <div class="equal-width month-list" v-for="(ms,j) in chunkArray(gMonths,3)">
                            <div v-for="(m,i) in ms" class="month" @click="gMonthPicking((i + (j * 3)))">
                                {{ m }}
                            </div>
                        </div>
                    </div>
                    <div v-if="tabIndex == 0 || _debug" dir="rtl">
                        <table>
                            <thead>
                            <tr>
                                <th v-for="day in pWeekDays">
                                    {{ day }}
                                </th>
                            </tr>
                            </thead>
                            <tbody v-if="pDate !== null">
                            <tr v-for="week in pArray">
                                <td v-for="d in week" :class="d.class +' '+ isActive(d)" :title="d.date"
                                    @click="select(d)">
                                    {{ pDate.parseHindi(d.pDay) }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="tabIndex == 1 || _debug">
                        <table>
                            <thead>
                            <tr>
                                <th v-for="day in gWeekDays">
                                    {{ day }}
                                </th>
                            </tr>
                            </thead>
                            <tbody v-if="pDate !== null">
                            <tr v-for="week in gArray">
                                <td v-for="d in week" :class="d.class +' '+ isActive(d) " :title="d.pdate"
                                    @click="select(d)">
                                    {{ d.day }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="bottom-bar">
                    <div>
                        <div class="vuejs-btn" title="Clear" @click="clear">
                            <i class="ri-eraser-line"></i>
                        </div>
                    </div>
                    <div class="centered">
                        <span v-if="pDate != null && '1970-0-1' != vgeDate.join('-')">
                            [{{ pDate.parseHindi(vpeDate.join('/')) }}]  [{{ vgeDate.join('-') }}]
                        </span>
                    </div>
                    <div>
                        <div class="vuejs-btn" title="Now" @click="nowSelect">
                            <i class="ri-time-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="datepicker">
            <input @focus="modalShow = true" :id="xid" :placeholder="xtitle" :class="getClass" type="text" :value="(val == null?'':fullData[xshow])" >
            <input type="hidden" :name="xname" :value="val">
        </div>
    </div>
</template>

<script>

import persianDate from './libs/persian-date.js';

const ONE_DAY = 86400;
const ONE_YEAR = ONE_DAY * 365;

function chunkArray(arr, count) {
    const result = [];

    for (let i = 0; i < arr.length; i += count) {
        result.push(arr.slice(i, i + count));
    }

    return result;
}

export default {
    name: "vue-datepicker",
    components: {},
    data: () => {
        return {
            _debug: false,
            fullData: {},
            modalShow: false,
            pDate: null,
            startYear: 1970,
            tabIndex: 0,
            current: null,
            gmPicker: false,
            pmPicker: false,
            yPicker: false,
            val: null,
            pWeekDays: [
                'ش',
                'ی',
                'د',
                'س',
                'چ',
                'پ',
                'آ',
            ],
            gWeekDays: [
                'Su',
                'Mo',
                'Tu',
                'We',
                'Th',
                'Fr',
                'Sa',
            ],
            pMonths: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            gMonths: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        }
    },
    props: {
        xvalue: {
            default: Math.floor(new Date() / 1000),
            type: Number,
        },
        xshow:{
          default: 'pdate',
          type: String,
        },
        onSelect: {
            default: function (date) {

            },
            type: Function,
        },
        pTitle: {
            default: 'Persian',
            type: String,
        },
        gTitle: {
            default: 'Gregorian',
            type: String,
        },
        defTab: {
            default: 0,
            type: Number,
        },
        xname: {
            default: "",
            type: String,
        },
        xtitle: {
            default: "",
            type: String,
        },
        xid: {
            default: "",
            type: String,
        },
        customClass: {
            default: "",
            type: String,
        },
        err: {
            default: false,
            type: Boolean,
        },
    },
    mounted() {
        this.pDate = new persianDate();
        let dt = new Date(this.xvalue * 1000);
        if (this.xvalue == null || this.xvalue == '' || this.xvalue == 'null'){
            dt = new Date();
            this.val = null;
            this.current= Math.floor(new Date() / 1000);
        }else{
            this.current = new Date(this.xvalue);
            this.val = this.xvalue;
        }
        this.fullData = this.makeDateObject(dt)
        // if (this.xvalue != this.val){
        //
        // }
    },
    computed: {
        getClass: function () {
            if (this.err == true || ( typeof this.err == 'String' && this.err.trim() == '1' )) {
                return 'form-control is-invalid '+this.customClass;
            }
            return 'form-control '+this.customClass;
        },
        gArray: function () {
            let result = [];
            const baseDate = this.current * 1000;
            let d = new Date(baseDate);
            const currentMonth = d.getMonth(baseDate);
            for (let i = 0; i >= -7; i--) {
                d = new Date(baseDate);
                d.setDate(i);
                result.push(this.makeDateObject(d, 'previous'));
                if (d.getDay() == 0) {
                    break;
                }
            }
            result = result.reverse();
            let nextCount = 0;
            for (let i = 1; i <= 45; i++) {
                d = new Date(baseDate);
                d.setDate(i);
                if (d.getMonth() == currentMonth) {
                    result.push(this.makeDateObject(d));
                } else {
                    if (d.getDay() == 0 && nextCount > 0) {
                        break;
                    }
                    result.push(this.makeDateObject(d, 'next'));
                    nextCount++;
                }
            }
            return chunkArray(result, 7);
        },
        pArray: function () {
            let result = [];
            const baseDate = this.current * 1000;
            let d = this.pDate.convertDate2Persian(new Date(baseDate));
            const currentMonth = d[1];
            for (let i = 0; i > -40; i--) {
                let dt = new Date(baseDate + (i * ONE_DAY * 1000));
                let pdt = this.pDate.convertDate2Persian(dt);
                if (pdt[1] == currentMonth) {
                    result.push(this.makeDateObject(dt));
                } else {
                    result.push(this.makeDateObject(dt, 'previous'));
                    if (this.makePWeek(dt) == 0) {
                        break;
                    }
                }
            }
            result = result.reverse();
            for (let i = 1; i < 40; i++) {
                let dt = new Date(baseDate + (i * ONE_DAY * 1000));
                let pdt = this.pDate.convertDate2Persian(dt);
                if (pdt[1] == currentMonth) {
                    result.push(this.makeDateObject(dt));
                } else {
                    result.push(this.makeDateObject(dt, 'next'));
                    if (this.makePWeek(dt) == 6) {
                        break;
                    }
                }
            }
            return chunkArray(result, 7);
        },
        geDate() {
            const baseDate = this.current * 1000;
            let d = new Date(baseDate);
            return [d.getFullYear(), d.getMonth(), d.getDate()];
        },
        peDate() {
            const baseDate = this.current * 1000;
            let d = new Date(baseDate);
            return this.pDate.convertDate2Persian(d);
        },
        vgeDate() {
            const baseDate = this.val * 1000;
            let d = new Date(baseDate);
            return [d.getFullYear(), d.getMonth(), d.getDate()];
        },
        vpeDate() {
            const baseDate = this.val * 1000;
            let d = new Date(baseDate);
            return this.pDate.convertDate2Persian(d);
        },
    },
    methods: {
        clear(){
            this.modalShow = false;
            this.val = null;
            this.fullData[this.xshow] = '';
        },
        nowSelect(){
            this.select(this.makeDateObject(new Date()));
        },
        select(obj) {
            if (obj.class == 'next') {
                this.next();
                return false;
            }
            if (obj.class == 'previous') {
                this.previous();
                return false;
            }
            this.onSelect(obj);
            this.val = obj.unix;
            this.modalShow = false;
            this.fullData = obj;
            return true;

        },
        yearPicking(i) {
            let dt = this.current * 1000;
            dt = new Date(dt);
            if (this.tabIndex == 1) {
                dt.setFullYear(i);
                this.current = Math.floor(dt / 1000);
            } else {
                let cYear = parseInt(this.peDate[0]);
                let diff = ONE_YEAR * (i - cYear);
                this.current = Math.floor((dt / 1000) + diff);
            }

            this.yPicker = false;
        },
        gMonthPicking(i) {
            let dt = this.current * 1000;
            dt = new Date(dt);
            dt.setMonth(parseInt(i));
            this.current = Math.floor(dt / 1000);
            this.gmPicker = false;
        },
        pMonthPicking(i) {
            let dt = this.current * 1000;
            dt = new Date(dt);
            let x = 10;
            if ((i + 1) != parseInt(this.peDate[1])) {
                if ((i + 1) < parseInt(this.peDate[1])) {
                    x = -10;
                }
                // for gregorian
                do {
                    dt.setDate(dt.getDate() + x);
                } while ((i + 1) != this.pDate.convertDate2Persian(dt)[1]);
                this.current = Math.floor(dt / 1000);
            }

            this.pmPicker = false;
        },
        next() {
            let dt = this.current * 1000;
            dt = new Date(dt);
            // for gregorian
            if (this.tabIndex == 1) {
                dt.setMonth(dt.getMonth() + 1);
            } else {
                let currentMonth = this.pDate.convertDate2Persian(new Date(dt))[1];
                do {
                    dt.setDate(dt.getDate() + 10);
                } while (currentMonth == this.pDate.convertDate2Persian(dt)[1]);
            }
            this.current = Math.floor(dt / 1000);
        },
        previous() {
            let dt = this.current * 1000;
            dt = new Date(dt);
            // for gregorian
            if (this.tabIndex == 1) {
                dt.setMonth(dt.getMonth() - 1);
            } else {
                let currentMonth = this.pDate.convertDate2Persian(new Date(dt))[1];
                do {
                    dt.setDate(dt.getDate() - 10);
                } while (currentMonth == this.pDate.convertDate2Persian(dt)[1]);
            }
            this.current = Math.floor(dt / 1000);
        },
        makeDateObject(dt, cls) {
            return {
                day: this.pDate.make2number(dt.getDate()),
                pDay: this.pDate.convertDate2Persian(dt)[2],
                date: dt.getFullYear() + '-' + dt.getMonth() + '-' + dt.getDate(),
                pdate: this.pDate.convertDate2Persian(dt).join('/'),
                weekDay: dt.getDay(),
                class: cls,
                unix: Math.floor(dt / 1000)
            };
        },
        makePWeek(dt) {
            let t = dt.getDay() + 1 % 7;
            if (t == 7) {
                return 0
            }
            return t;
        },
        monthPick() {
            if (this.tabIndex == 1) {
                this.gmPicker = !this.gmPicker;
                this.pmPicker = false;
            } else {
                this.pmPicker = !this.pmPicker;
                this.gmPicker = false;
            }
        },
        yearPick() {
            if (this.tabIndex == 1) {
                this.startYear = parseInt(this.geDate[0]);
            } else {
                this.startYear = parseInt(this.peDate[0]);
            }
            this.yPicker = !this.yPicker;
        },
        isActive(obj){
            let dt = new Date(this.val * 1000);
            if (dt.getFullYear()+'-'+dt.getMonth()+'-'+dt.getDate() == obj.date){
                return 'active-selected';
            }
            return  '';
        },
        chunkArray: chunkArray,
    },
}
</script>

<style scoped>
#vue-datepicker {
    font-size: 12pt;
}

#dp-modal {
    position: fixed;
//display: none; left: 0; right: 0; top: 0; bottom: 0; z-index: 999; background: #00000033;
    backdrop-filter: blur(4px);
}

#picker {
    max-width: 400px;
    min-height: 450px;
    margin: calc(50vh - 225px) auto;
    background: #ffffffdd;
    backdrop-filter: blur(4px);
    user-select: none;
    color: black;
    padding: 5px;
    font-family: 'Vazir', 'Vazirmatn', sans-serif;
}

#picker table {
    border: 1px solid black;
    width: 100%;
    margin-top: 5px;
}

#picker table td, #picker table th {
    border: 1px solid silver;
    width: calc(100% / 7);
    text-align: center;
    padding: 7px;
    transition: 500ms;
}

#picker table td:hover {
    background: deepskyblue;
    cursor: pointer;
}

#picker .next, #picker .previous {
    color: gray;
}

.equal-width {
    display: grid;
    grid-auto-columns: minmax(0, 1fr);
    grid-auto-flow: column;
    text-align: center;
    cursor: pointer;
}

.equal-width div {
    padding: .5rem 5px;
    font-weight: 800;
}

.equal-width div i {
    font-size: 25px;
}

#bottom-bar {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    text-align: center;
}

#bottom-bar > div {
    padding: 7px 4px;
}

#vuejs-tabs {
    border: 1px solid gray;
    margin-bottom: .5rem;
}

.equal-width div:hover {
    background: teal;
    color: white;;
}

.active-tab {
    background: deepskyblue;
    color: white;
}

.vuejsbtn {
    padding: 1px !important;
}

#calendar-container {
    position: relative;
    min-height: 285px;
}

.sub-picker {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    background: white;
}

.month {
    padding: 1.4rem 0 !important;
}

.year {
    padding: .97rem 0 !important;
}

.vuejs-btn {
    padding: 3px;
    background: silver;
    display: block;
    cursor: pointer;
}

.vuejs-btn:hover {
    background: deepskyblue;
    color: white;
}

.vuejs-btn i {
    font-size: 20px;
}

.centered {
    display: flex;
    align-items: center;
    justify-content: center;
}

.centered span {
    margin-top: 6px;
    display: inline-block;
}
.active-selected{
    background: teal;
    color: white;;
}
</style>
