import{A as _}from"./ApplicationLogo-hBQdwhqp.js";import{b as g,a as x,_ as b,c as L}from"./ResponsiveNavLink-6myVXAOU.js";import{i as z,e as i,o as m,c as p,b as e,a as o,w as t,t as d,h as r,n as a,s as k}from"./app-eYzKjRAK.js";import{T as y}from"./Toast-1KncQ8CD.js";import{_ as M}from"./_plugin-vue_export-helper-x3n3nnut.js";const C={components:{ApplicationLogo:_,Dropdown:g,DropdownLink:x,NavLink:b,ResponsiveNavLink:L,Link:z,Toast:y},data(){return{showingNavigationDropdown:!1,errors:null}},watch:{errors:{handler(s,c){Object.keys(s).length>0&&this.$refs.toast.show("success","Tidak ada layanan!",errors==null?void 0:errors.message)},deep:!0}},props:{message:String},mounted(){this.$page.props.errors&&(this.errors=this.$page.props.errors,setTimeout(()=>{this.$refs.toast&&this.$refs.toast.hide()},6e3))}},N={class:"min-h-screen bg-gray-100"},D={class:"bg-white border-b border-neutral-300"},B={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},V={class:"flex justify-between h-16"},A={class:"flex"},$=e("div",{class:"shrink-0 flex items-center"},null,-1),H={class:"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"},T=e("img",{class:"w-10 mr-2",src:"/storage/webLogo.png",alt:""},null,-1),j=e("span",null,"Form Generator",-1),S={class:"hidden sm:flex sm:items-center sm:ms-6"},F={class:"ms-3 relative"},O={class:"inline-flex rounded-md"},R={type:"button",class:"inline-flex space-x-2 items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-transparent text-neutral-900 hover:bg-rose-200 hover:text-rose-600 focus:outline-none transition ease-in-out duration-150"},I=e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"0.88em",height:"1em",viewBox:"0 0 448 512"},[e("path",{fill:"currentColor",d:"M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4"})],-1),P=e("svg",{class:"ms-2 -me-0.5 h-4 w-4",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z","clip-rule":"evenodd"})],-1),Z={class:"-me-2 flex items-center sm:hidden"},E={class:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},G=e("div",{class:"pt-2 pb-3 space-y-1"},null,-1),W={class:"pt-4 pb-1 border-t border-gray-200"},q={class:"px-4"},J={class:"font-medium text-base text-gray-800"},K={class:"font-medium text-sm text-gray-500"},Q={class:"mt-3 space-y-1"},U={class:"flex flex-row"},X={class:"drawer drawer-open w-fit"},Y=e("input",{id:"my-drawer-2",type:"checkbox",class:"drawer-toggle"},null,-1),e0={class:"drawer-side"},s0=e("label",{for:"my-drawer-2","aria-label":"close sidebar",class:"drawer-overlay"},null,-1),o0={class:"menu p-4 space-y-2 hidden sm:block w-80 min-h-full bg-white shadow text-neutral-900"},t0=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4",viewBox:"0 0 15 15"},[e("path",{fill:"currentColor",d:"m7.5.5l.325-.38a.5.5 0 0 0-.65 0zm-7 6l-.325-.38L0 6.27v.23zm5 8v.5a.5.5 0 0 0 .5-.5zm4 0H9a.5.5 0 0 0 .5.5zm5-8h.5v-.23l-.175-.15zM1.5 15h4v-1h-4zm13.325-8.88l-7-6l-.65.76l7 6zm-7.65-6l-7 6l.65.76l7-6zM6 14.5v-3H5v3zm3-3v3h1v-3zm.5 3.5h4v-1h-4zm5.5-1.5v-7h-1v7zm-15-7v7h1v-7zM7.5 10A1.5 1.5 0 0 1 9 11.5h1A2.5 2.5 0 0 0 7.5 9zm0-1A2.5 2.5 0 0 0 5 11.5h1A1.5 1.5 0 0 1 7.5 10zm6 6a1.5 1.5 0 0 0 1.5-1.5h-1a.5.5 0 0 1-.5.5zm-12-1a.5.5 0 0 1-.5-.5H0A1.5 1.5 0 0 0 1.5 15z"})],-1),l0=e("hr",null,null,-1),n0=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4",viewBox:"0 0 1024 1024"},[e("path",{fill:"currentColor",d:"M904 512h-56c-4.4 0-8 3.6-8 8v320H184V184h320c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V520c0-4.4-3.6-8-8-8"}),e("path",{fill:"currentColor",d:"M355.9 534.9L354 653.8c-.1 8.9 7.1 16.2 16 16.2h.4l118-2.9c2-.1 4-.9 5.4-2.3l415.9-415c3.1-3.1 3.1-8.2 0-11.3L785.4 114.3c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-415.8 415a8.3 8.3 0 0 0-2.3 5.6m63.5 23.6L779.7 199l45.2 45.1l-360.5 359.7l-45.7 1.1z"})],-1),r0=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4",viewBox:"0 0 24 24"},[e("path",{fill:"currentColor",d:"M9.86 21.43L9 22l-3-2l-3 2V3h18v7.2c-.63-.27-1.36-.27-2 .02V5H5v13.26l1-.66l3 2l.86-.6zm2-1.47L18 13.83l2.03 2.04L13.9 22h-2.04zm8.87-4.79l.98-.98c.2-.19.2-.52 0-.72l-1.32-1.32a.24.24 0 0 0-.08-.06a.497.497 0 0 0-.62.04l-.02.02l-.98.98z"})],-1),a0=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4",viewBox:"0 0 24 24"},[e("path",{fill:"currentColor",d:"M19.05 4.91A9.816 9.816 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.264 8.264 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.183 8.183 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07c0 1.22.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28"})],-1),i0={class:"w-full"},c0={class:"btm-nav display sm:hidden"},d0=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-6 text-blue-600",viewBox:"0 0 24 24"},[e("path",{fill:"currentColor",d:"M4 21V9l8-6l8 6v12h-6v-7h-4v7z"})],-1),h0=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-6 text-blue-600",viewBox:"0 0 36 36"},[e("path",{fill:"currentColor",d:"m33 6.4l-3.7-3.7a1.71 1.71 0 0 0-2.36 0L23.65 6H6a2 2 0 0 0-2 2v22a2 2 0 0 0 2 2h22a2 2 0 0 0 2-2V11.76l3-3a1.67 1.67 0 0 0 0-2.36M18.83 20.13l-4.19.93l1-4.15l9.55-9.57l3.23 3.23ZM29.5 9.43L26.27 6.2l1.85-1.85l3.23 3.23Z",class:"clr-i-solid clr-i-solid-path-1"}),e("path",{fill:"none",d:"M0 0h36v36H0z"})],-1),u0=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-6 text-blue-600",viewBox:"0 0 24 24"},[e("path",{fill:"currentColor",d:"M9.86 21.43L9 22l-3-2l-3 2V3h18v7.2c-.9-.38-2-.2-2.76.55l-8.38 8.38zm2-1.47L18 13.83l2.03 2.04L13.9 22h-2.04zm8.53-7.81a.24.24 0 0 0-.08-.06a.497.497 0 0 0-.62.04l-.02.02l-.98.98l2.04 2.04l.98-.98c.2-.19.2-.52 0-.72z"})],-1),m0=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-6 text-blue-600",viewBox:"0 0 24 24"},[e("g",{fill:"none","fill-rule":"evenodd"},[e("path",{d:"M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"}),e("path",{fill:"currentColor",d:"M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.546 20.2A1.01 1.01 0 0 0 3.8 21.454l3.032-.892A9.957 9.957 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2M9.738 14.263c2.023 2.022 3.954 2.289 4.636 2.314c1.037.038 2.047-.754 2.44-1.673a.696.696 0 0 0-.088-.703c-.548-.7-1.289-1.203-2.013-1.703a.711.711 0 0 0-.973.158l-.6.915a.229.229 0 0 1-.305.076c-.407-.233-1-.629-1.426-1.055c-.426-.426-.798-.992-1.007-1.373a.227.227 0 0 1 .067-.291l.924-.686a.712.712 0 0 0 .12-.94c-.448-.656-.97-1.49-1.727-2.043a.695.695 0 0 0-.684-.075c-.92.394-1.716 1.404-1.678 2.443c.025.682.292 2.613 2.314 4.636"})])],-1);function p0(s,c,v0,f0,l,w0){const v=i("NavLink"),h=i("DropdownLink"),f=i("Dropdown"),u=i("ResponsiveNavLink"),n=i("Link"),w=i("Toast");return m(),p("div",null,[e("div",N,[e("nav",D,[e("div",B,[e("div",V,[e("div",A,[$,e("div",H,[o(v,{class:"text-neutral-900 font-semibold text-xl space-x-2",href:s.route("panel.dashboard"),active:s.route().current("dashboard")},{default:t(()=>[T,j]),_:1},8,["href","active"])])]),e("div",S,[e("div",F,[o(f,{align:"right",width:"48"},{trigger:t(()=>[e("span",O,[e("button",R,[I,e("span",null,d(s.$page.props.auth.user.name),1),P])])]),content:t(()=>[o(h,{href:s.route("profile.edit")},{default:t(()=>[r(" Profile ")]),_:1},8,["href"]),o(h,{href:s.route("logout"),method:"post",as:"button"},{default:t(()=>[r(" Log Out ")]),_:1},8,["href"])]),_:1})])]),e("div",Z,[e("button",{onClick:c[0]||(c[0]=_0=>l.showingNavigationDropdown=!l.showingNavigationDropdown),class:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"},[(m(),p("svg",E,[e("path",{class:a({hidden:l.showingNavigationDropdown,"inline-flex":!l.showingNavigationDropdown}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h16M4 18h16"},null,2),e("path",{class:a({hidden:!l.showingNavigationDropdown,"inline-flex":l.showingNavigationDropdown}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"},null,2)]))])])])]),e("div",{class:a([{block:l.showingNavigationDropdown,hidden:!l.showingNavigationDropdown},"sm:hidden"])},[G,e("div",W,[e("div",q,[e("div",J,d(s.$page.props.auth.user.name),1),e("div",K,d(s.$page.props.auth.user.email),1)]),e("div",Q,[o(u,{href:s.route("profile.edit")},{default:t(()=>[r(" Profile ")]),_:1},8,["href"]),o(u,{href:s.route("logout"),method:"post",as:"button"},{default:t(()=>[r(" Log Out ")]),_:1},8,["href"])])])],2)]),e("main",U,[e("div",X,[Y,e("div",e0,[s0,e("ul",o0,[e("li",null,[o(n,{class:a([{"!text-blue-600 font-semibold":s.route().current("client.dashboard")},"text-neutral-500"]),href:s.route("client.dashboard")},{default:t(()=>[t0,r(" Dashboard ")]),_:1},8,["class","href"])]),l0,e("li",null,[o(n,{class:a([{"!text-blue-600 font-semibold":s.route().current("client.form.*")},"text-neutral-500"]),href:s.route("client.form.index")},{default:t(()=>[n0,r(" Manajemen Formulir ")]),_:1},8,["class","href"])]),e("li",null,[o(n,{class:a([{"!text-blue-600 font-semibold":s.route().current("client.invoice.*")},"text-neutral-500"]),href:s.route("client.invoice.clientIndex")},{default:t(()=>[r0,r(" Manajemen Faktur ")]),_:1},8,["class","href"])]),e("li",null,[o(n,{class:a([{"!text-blue-600 font-semibold":s.route().current("client.wa.*")},"text-neutral-500"]),href:s.route("client.wa.index")},{default:t(()=>[a0,r(" Layanan Whatsapp ")]),_:1},8,["class","href"])])])])]),e("div",i0,[o(w),k(s.$slots,"default")]),e("div",c0,[o(n,{href:s.route("client.dashboard")},{default:t(()=>[d0]),_:1},8,["href"]),o(n,{href:s.route("client.form.index")},{default:t(()=>[h0]),_:1},8,["href"]),o(n,{href:s.route("client.invoice.clientIndex")},{default:t(()=>[u0]),_:1},8,["href"]),o(n,{href:s.route("client.wa.index")},{default:t(()=>[m0]),_:1},8,["href"])])])])])}const k0=M(C,[["render",p0]]);export{k0 as A};
