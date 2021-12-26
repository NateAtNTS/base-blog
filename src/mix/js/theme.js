import Vue from 'vue'

if(document.getElementById("editor")) {
    let vuejsResponses = new Vue({
        el: "#editor",
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


