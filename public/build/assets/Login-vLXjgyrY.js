import{x as b,g as x,m as y,o as n,c as w,T as v,j as c,w as d,a,u as s,Z as V,t as B,f as p,b as r,i as C,h as f,n as $,s as P}from"./app-VmSF2JD4.js";import{_ as q}from"./GuestLayout-q0WM0GxS.js";import{_ as g,a as _}from"./InputLabel-D6DyKqXe.js";import{P as N}from"./PrimaryButton-dIoLyl4C.js";import{_ as h}from"./TextInput--m8Zpf9c.js";import"./ApplicationLogo-9BS91Z7e.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const U=["value"],L={__name:"Checkbox",props:{checked:{type:[Array,Boolean],required:!0},value:{default:null}},emits:["update:checked"],setup(l,{emit:e}){const i=e,m=l,t=b({get(){return m.checked},set(o){i("update:checked",o)}});return(o,u)=>x((n(),w("input",{type:"checkbox",value:l.value,"onUpdate:modelValue":u[0]||(u[0]=k=>t.value=k),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"},null,8,U)),[[y,t.value]])}},R={key:0,class:"mb-4 font-medium text-sm text-green-600"},S={class:"mt-4"},j={class:"block mt-4"},D={class:"flex items-center"},E=r("span",{class:"ms-2 text-sm text-gray-600"},"Remember me",-1),F={class:"flex items-center justify-end mt-4"},I={__name:"Login",props:{canResetPassword:{type:Boolean},status:{type:String}},setup(l){const e=v({email:"",password:"",remember:!1}),i=()=>{e.post(route("authenticate"),{headers:{"ngrok-skip-browser-warning":!0},onFinish:()=>e.reset("password")})};return(m,t)=>(n(),c(q,null,{default:d(()=>[a(s(V),{title:"Log in"}),l.status?(n(),w("div",R,B(l.status),1)):p("",!0),r("form",{onSubmit:P(i,["prevent"])},[r("div",null,[a(g,{for:"email",value:"Email"}),a(h,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":t[0]||(t[0]=o=>s(e).email=o),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(_,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),r("div",S,[a(g,{for:"password",value:"Password"}),a(h,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":t[1]||(t[1]=o=>s(e).password=o),required:"",autocomplete:"current-password"},null,8,["modelValue"]),a(_,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),r("div",j,[r("label",D,[a(L,{name:"remember",checked:s(e).remember,"onUpdate:checked":t[2]||(t[2]=o=>s(e).remember=o)},null,8,["checked"]),E])]),r("div",F,[l.canResetPassword?(n(),c(s(C),{key:0,href:m.route("password.request"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:d(()=>[f(" Forgot your password? ")]),_:1},8,["href"])):p("",!0),a(N,{class:$(["ms-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:d(()=>[f(" Log in ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{I as default};
