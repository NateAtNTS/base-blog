import Vue from 'vue'

if(document.getElementById("nothing")) {
    let vuejsResponses = new Vue({
        el: "#nothing",
        delimiters: ["${", "}"],
        data: {
            myHTML: `you have arrived!!`
        },
        methods: {},
        created() {

            },
        destroyed() {
        },
        mounted() {
        },
    });
} // if div exists








