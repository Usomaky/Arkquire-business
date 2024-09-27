<script>
export default{
    props:{
        length: {
            type: Number,
            default: 4
        },
        modelValue:{}
    },
    emits: ['update:modelValue'],
    data(){
        return{
            otp: []
        }
    },
    watch:{
        modelValue(){
            if(this.modelValue === null){
                this.populate();
            }
        }
    },
    methods:{
        populate(){
            for (let index = 0; index < this.length; index++) {
                this.otp[index] = null;
            }
        },
        makeInteger(){
            return this.otp.join('') ? parseInt(this.otp.join('')) : null;
        },
        limitEntry(index,event){
            const limit = 1;

            // If value is null
            if(!this.otp[index]){
                return;
            }

            if(this.otp[index]?.toString().length > limit){
                let text = this.otp[index]?.toString().slice(0, this.length - index);
                let counter = 0;

                for (let i = index; i < this.length; i++) {
                    this.otp[i] = parseInt(text[counter]);
                    counter++;
                }
            }
            else{
                if((index+1) < this.length){
                    this.$refs[`input${index+1}`][0].focus();
                }
                else{
                    this.$refs[`input${index}`][0].blur();
                }
            }
            this.$emit('update:modelValue',this.makeInteger(this.otp));
        },
        handleBackSpace(index,event){
            const keyCode = event.keyCode;

            // if key is backspace
            if(keyCode === 8){
                if((index-1) >= 0){
                    this.otp[index] = null;
                    this.$refs[`input${index-1}`][0].focus();
                }
            }
        }
    },
    beforeMount(){
        this.populate();
    },
    mounted(){
        // console.log(this.$refs);
    }
}
</script>

<style scoped>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.input{
    @apply w-12 h-12 appearance-none border rounded-lg outline-primary-400 text-xl text-slate-800 font-semibold text-center
}
</style>

<template>
    <div class="flex items-center gap-2">
        <input
            @keyup="handleBackSpace(index-1,$event)"
            @input="limitEntry(index-1,$event)"
            class="input"
            type="number"
            v-model="otp[index-1]"
            v-for="index in length"
            :key="index"
            :ref="`input${index-1}`"
        />
    </div>
</template>
