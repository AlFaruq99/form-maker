import{Z as D,i as A,d as N,e as u,o as i,c as r,a as _,w as d,F as p,b as t,t as l,h as b,g,k as w,r as m,v as T,j as V,f as L,n as j}from"./app-VmSF2JD4.js";import{_ as H}from"./AuthenticatedLayoutAdmin-Pmh5JjvS.js";import{T as I}from"./Table--r9-itQ3.js";import{_ as M}from"./TextInput--m8Zpf9c.js";import{h as v}from"./moment-WSJ9un1t.js";import{_ as S}from"./_plugin-vue_export-helper-x3n3nnut.js";import"./ResponsiveNavLink-W2eVyQKm.js";function U(o){const s=o.split(" ");return`${s[0].charAt(0)}${s[1]?s[1].charAt(0):""}`}const B={components:{AuthenticatedLayoutAdmin:H,Head:D,TableVue:I,TextInput:M,Link:A},props:{total_client:Number,client_active:Number,client_inactive:Number},data(){return{client:Array,length:10,page:this.page,search:null,status:"all"}},mounted(){this.getClientData()},watch:{search(){this.getClientData()},length(o){length=o,this.getClientData()},status(){this.getClientData()}},methods:{changePageHandler(o){let s=new URL(o);s.searchParams.set("length",this.length),s.searchParams.set("status",this.status),this.search&&s.searchParams.set("search",this.search),this.getClientData(s.href)},async getClientData(o){const s=o??route("panel.user.clientData",{length:this.length,search:this.search,status:this.status}),h=await N.get(s).then(f=>{let a=f.data;try{return a.data.map(n=>(n.initialName=U(n.name),n.subscription==null?n.status="Inactive":v(n.subscription.expired_at,"YYYY-MM-DD").toDate()<v.now()?(n.jatuh_tempo=v(n.subscription.expired_at).locale("ID").fromNow(),n.status="Inactive"):(n.jatuh_tempo=v(n.subscription.expired_at).locale("ID").fromNow(),n.status="Active"),n)),a}catch{return[]}}).catch(f=>{alert("gagal mengambil data")});this.client=h}}},E=t("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Dashboard",-1),P={class:"py-12"},Y={class:"max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6"},z={class:"stats shadow w-fit"},F={class:"stat"},R=t("div",{class:"stat-title"},"Total Client",-1),Z={class:"stat-value"},q={class:"stat"},G=t("div",{class:"stat-title"},"Active User",-1),J={class:"stat-value text-primary"},K={class:"stat"},O=t("div",{class:"stat-title"},"Inactive User",-1),Q={class:"stat-value text-error"},W={class:"bg-white card overflow-hidden"},X={class:"p-6 text-gray-900 grid grid-cols gap-6"},$={class:"container"},tt=t("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-6",viewBox:"0 0 24 24"},[t("path",{fill:"currentColor",d:"M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m5 11h-4v4h-2v-4H7v-2h4V7h2v4h4z"})],-1),et={class:"container filter-container flex flex-row justify-between"},st={class:"inline-flex space-x-2"},at=t("option",{value:"10"},"10",-1),nt=["value","hidden"],lt=t("option",{value:"all"},"Show all",-1),ot=t("option",{value:"active"},"Active",-1),it=t("option",{value:"inactive"},"Expired",-1),ct=[lt,ot,it],rt={class:"inline-flex space-x-2"},dt={class:"container grid grid-cols-1 gap-6"},ht=t("thead",null,[t("tr",null,[t("th"),t("th"),t("th",null,"Name"),t("th",null,"Email"),t("th",null,"Subscription"),t("th",null,"Expired"),t("th")])],-1),ut={class:"avatar placeholder"},_t={class:"bg-neutral text-neutral-content rounded-full w-12"},pt={class:"w-full flex flex-row justify-between"},vt={class:"join"},ft=["onClick","innerHTML"];function gt(o,s,h,f,a,n){const y=u("Head"),x=u("Link"),k=u("TableVue"),C=u("AuthenticatedLayoutAdmin");return i(),r(p,null,[_(y,{title:"Manajemen User"}),_(C,null,{header:d(()=>[E]),default:d(()=>[t("div",P,[t("div",Y,[t("div",z,[t("div",F,[R,t("div",Z,l(h.total_client),1)]),t("div",q,[G,t("div",J,l(h.client_active),1)]),t("div",K,[O,t("div",Q,l(h.client_inactive),1)])]),t("div",W,[t("div",X,[t("div",$,[_(x,{href:o.route("panel.user.create"),class:"btn btn-md btn-primary float-end"},{default:d(()=>[tt,b(" Tambah ")]),_:1},8,["href"])]),t("div",et,[t("div",st,[g(t("select",{class:"select select-bordered w-fit max-w-xs","onUpdate:modelValue":s[0]||(s[0]=e=>a.length=e)},[at,(i(),r(p,null,m(100,(e,c)=>t("option",{value:e,hidden:e%25!=0,key:c},l(e),9,nt)),64))],512),[[w,a.length]]),g(t("select",{"onUpdate:modelValue":s[1]||(s[1]=e=>a.status=e),class:"select select-bordered w-fit max-w-xs"},ct,512),[[w,a.status]])]),t("div",rt,[g(t("input",{"onUpdate:modelValue":s[2]||(s[2]=e=>a.search=e),type:"text",name:"",class:"input input-bordered input-md w-full max-w-xs",placeholder:"Search..."},null,512),[[T,a.search]])])]),t("div",dt,[_(k,null,{header:d(()=>[ht]),body:d(()=>[t("tbody",null,[(i(!0),r(p,null,m(a.client.data,(e,c)=>(i(),r("tr",{key:c},[t("th",null,l(a.client.from+c),1),t("th",null,[t("div",ut,[t("div",_t,[t("span",null,l(e.initialName),1)])])]),t("td",null,l(e==null?void 0:e.name),1),t("td",null,l(e==null?void 0:e.email),1),t("td",null,l(e==null?void 0:e.status),1),t("td",null,l(e==null?void 0:e.jatuh_tempo),1),t("td",null,[e.status=="Inactive"?(i(),V(x,{key:0,href:o.route("panel.user.userActivation",{id:e.id}),class:"btn btn-sm text-white bg-blue-500"},{default:d(()=>[b("Activate")]),_:2},1032,["href"])):L("",!0)])]))),128))])]),_:1}),t("div",pt,[t("p",null," Show "+l(a.client.from)+" - "+l(a.client.to)+" form total "+l(a.client.total)+" data ",1),t("div",vt,[(i(!0),r(p,null,m(a.client.links,(e,c)=>(i(),r("div",{key:c},[t("button",{onClick:()=>{n.changePageHandler(e.url)},class:j(["join-item btn btn-sm",{"bg-primary text-white":e.active}]),innerHTML:e.label},null,10,ft)]))),128))])])])])])])])]),_:1})],64)}const Dt=S(B,[["render",gt]]);export{Dt as default};
