import"./sweetalert2.all-501eb1a9.js";import{_ as p,r as a,o as r,e as d,w as e,a as t,b as u,t as h,c as m,d as _,f as i}from"./app-4c5af1ad.js";const x={props:{user:{default:{},type:Object}}};function b(f,v,l,g,w,o){const n=a("v-img"),s=a("v-avatar"),c=a("v-chip");return r(),d(c,{pill:""},{default:e(()=>[t(s,{start:""},{default:e(()=>[t(n,{src:l.user.image_url},null,8,["src"])]),_:1}),u(" "+h(l.user.name),1)]),_:1})}const k=p(x,[["render",b]]);const y={computed:{user(){return this.$store.getters.loggedInUser}},components:{UserAvatar:k},data(){return{imgSrc:""}},methods:{},watch:{},async mounted(){}},$={class:"main-dashboard"},B={class:"man-dish-inner"},N={class:"text-center px-5"},V={class:""},C={key:0,class:"paragraph pa-0 px-5"};function E(f,v,l,g,w,o){const n=a("v-btn"),s=a("v-col"),c=a("v-row");return r(),m("div",$,[_("div",B,[t(c,null,{default:e(()=>[t(s,{lg:"12",md:"12",sm:"12",class:"px-5"},{default:e(()=>[_("h1",N,"Hello "+h(o.user.name)+",",1),_("div",V,[o.user.role_id==1?(r(),m("p",C,"Here at MG Enthusiasts, we're thrilled to introduce our newest members, each of whom has contributed fantastic videography showcasing the remarkable MG HS. To savor the unique charm of each video, we invite you to click on the following button, where a world of MG excellence awaits your exploration.")):i("",!0)]),o.user.role_id==1?(r(),d(n,{key:0,class:"ma-0 mt-3 registration text-white",exact:"",to:{name:"auth.users.listing"},link:!0},{default:e(()=>[u("Registrations")]),_:1},8,["to"])):i("",!0)]),_:1}),o.user.role_id==2?(r(),d(s,{key:0,cols:"12",class:"mb-2"},{default:e(()=>[t(c,{class:"dash-btn"},{default:e(()=>[t(s,{sm:"6",md:"6",lg:"6"}),t(s,{sm:"6",md:"6",lg:"6",class:"edit-profile-button"},{default:e(()=>[t(n,{block:"",class:"edit-profile text-white",to:{name:"auth.profiles"},link:""},{default:e(()=>[u("Edit Profile")]),_:1},8,["to"])]),_:1})]),_:1})]),_:1})):i("",!0)]),_:1})])])}const M=p(y,[["render",E],["__scopeId","data-v-1aaffd94"]]);export{M as default};