import{d as _}from"./default-05df27b5.js";import{S as C}from"./sweetalert2.all-501eb1a9.js";import{_ as U,r as a,e as f,w as l,o as h,a as t,b,d as I,f as k,t as D,g as N}from"./app-4c5af1ad.js";const d=new _("admin-task"),q=new _("roles"),F={data(){return{roles:[],breadcrumbs:[{title:"Dashboard",to:{name:"auth.panel"},disabled:!1,exact:!0},{title:"Users",exact:!0,disabled:!1,to:{name:"auth.users.listing"}}],form:{role_id:"",name:"",dob:"",cnic:"",email:"",password:"",thumbnail_url:"",image:"",city:"",phone:"",own_mg:!0,id:0},loading:!1,errors:{role_id:[],dob:[],cnic:[],name:[],email:[],password:[],thumbnail:[],city:[],phone:[],own_mg:[]}}},methods:{formatCNIC(){const o=this.form.cnic.replace(/\D/g,"");this.form.cnic=o.substring(0,13).replace(/^(\d{5})(\d{7})(\d{1})$/,"$1-$2-$3")},formatPhone(){const o=this.form.phone.replace(/\D/g,"");this.form.phone=o.substring(0,12).replace(/(\d{2})(\d{3})(\d{7})/,"+$1 $2 $3")},async insertRecord(){this.resetErrors(),this.loading=!0;var o=new FormData;if(o.append("name",this.form.name),o.append("dob",this.form.dob),o.append("cnic",this.form.cnic),o.append("email",this.form.email),o.append("role_id",this.form.role_id),o.append("city",this.form.city),o.append("phone",this.form.phone),o.append("own_mg",this.form.own_mg==!0?1:0),this.form.thumbnail&&o.append("thumbnail",this.form.thumbnail),this.form.id>0){o.append("id",this.form.id),this.form.password!=""&&o.append("password",this.form.password);var e=await d.update(o,this.form.id)}else{o.append("password",this.form.password);var e=await d.create(o)}e.status?(C.fire("Inserted!","Your record has been inserted.","success"),this.$router.push({name:"auth.users.listing"})):(e.data.name&&(this.errors.name=e.data.name),e.data.dob&&(this.errors.dob=e.data.dob),e.data.cnic&&(this.errors.cnic=e.data.cnic),e.data.email&&(this.errors.email=e.data.email),e.data.role_id&&(this.errors.role_id=e.data.role_id),e.data.thumbnail&&(this.errors.thumbnail=e.data.thumbnail),e.data.password&&(this.errors.password=e.data.password),e.data.city&&(this.errors.city=e.data.city),e.data.phone&&(this.errors.phone=e.data.phone)),this.loading=!1},onFileChange(o){this.form.thumbnail=o.target.files[0]},resetErrors(){this.errors={role_id:[],name:[],email:[],password:[],thumbnail:[],dob:[],cnic:[],city:[],phone:[]}}},watch:{},async mounted(){if(this.roles=await q.getlist("").then(e=>e.data),this.$route.params.id){this.form.id=this.$route.params.id,this.breadcrumbs.push({title:"Edit",exact:!0,disabled:!0,to:{name:"auth.users.add",params:{id:this.$route.params.id}}});var o=await d.get(this.$route.params.id);this.form={name:o.name?o.name:"",cnic:o.cnic?o.cnic:"",dob:o.dob?o.dob:"",email:o.email?o.email:"",phone:o.phone?o.phone:"",city:o.city?o.city:"",role_id:o.role_id?o.role_id:"",own_mg:o.own_mg!=0,id:this.$route.params.id,thumbnail_url:o.image_url}}else this.breadcrumbs.push({title:"Add",exact:!0,disabled:!0,to:{name:"auth.users.add"}})},computed:{cities(){return this.$store.getters.getCities}}};function P(o,e,S,B,r,m){const u=a("v-icon"),g=a("v-breadcrumbs"),i=a("v-col"),w=a("v-img"),v=a("v-avatar"),n=a("v-text-field"),p=a("v-select"),V=a("v-file-input"),y=a("v-checkbox"),x=a("v-btn"),c=a("v-row");return h(),f(c,null,{default:l(()=>[t(i,{cols:"12"},{default:l(()=>[t(g,{items:r.breadcrumbs},{prepend:l(()=>[t(u,{size:"small",icon:"mdi-home-city"})]),divider:l(()=>[t(u,null,{default:l(()=>[b("mdi-forward")]),_:1})]),_:1},8,["items"])]),_:1}),t(i,{cols:"12"},{default:l(()=>[I("form",{onSubmit:e[10]||(e[10]=N((...s)=>o.submit&&o.submit(...s),["prevent"]))},[t(c,null,{default:l(()=>[t(i,{class:"text-center",cols:"12"},{default:l(()=>[r.form.id>0?(h(),f(v,{key:0,size:"200px"},{default:l(()=>[t(w,{alt:"Avatar",src:r.form.thumbnail_url},null,8,["src"])]),_:1})):k("",!0)]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(n,{modelValue:r.form.name,"onUpdate:modelValue":e[0]||(e[0]=s=>r.form.name=s),counter:255,label:"First Name",required:"","error-messages":r.errors.name},null,8,["modelValue","error-messages"])]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(n,{modelValue:r.form.cnic,"onUpdate:modelValue":e[1]||(e[1]=s=>r.form.cnic=s),label:"CNIC",required:"","error-messages":r.errors.cnic,onInput:m.formatCNIC,maxlength:"15"},null,8,["modelValue","error-messages","onInput"])]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(n,{modelValue:r.form.dob,"onUpdate:modelValue":e[2]||(e[2]=s=>r.form.dob=s),label:"DOB",type:"date",required:"","error-messages":r.errors.dob},null,8,["modelValue","error-messages"])]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(n,{modelValue:r.form.email,"onUpdate:modelValue":e[3]||(e[3]=s=>r.form.email=s),counter:255,label:"Email",required:"","error-messages":r.errors.email},null,8,["modelValue","error-messages"])]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(n,{modelValue:r.form.password,"onUpdate:modelValue":e[4]||(e[4]=s=>r.form.password=s),label:"Password",type:"password","error-messages":r.errors.password},null,8,["modelValue","error-messages"])]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(n,{modelValue:r.form.phone,"onUpdate:modelValue":e[5]||(e[5]=s=>r.form.phone=s),label:"Phone",required:"","error-messages":r.errors.phone,onInput:m.formatPhone,maxlength:"14"},null,8,["modelValue","error-messages","onInput"])]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(p,{"error-messages":r.errors.city,"item-title":"text","item-value":"keyt",label:"City",items:m.cities,modelValue:r.form.city,"onUpdate:modelValue":e[6]||(e[6]=s=>r.form.city=s)},null,8,["error-messages","items","modelValue"])]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(V,{modelValue:r.form.image,"onUpdate:modelValue":e[7]||(e[7]=s=>r.form.image=s),counter:255,label:"Profile Image",required:"","error-messages":r.errors.image,onChange:m.onFileChange},null,8,["modelValue","error-messages","onChange"])]),_:1}),t(i,{cols:"6"},{default:l(()=>[t(p,{"error-messages":r.errors.role_id,"item-title":"title","item-value":"id",label:"Role",items:r.roles,modelValue:r.form.role_id,"onUpdate:modelValue":e[8]||(e[8]=s=>r.form.role_id=s)},null,8,["error-messages","items","modelValue"])]),_:1}),t(i,{cols:"3"},{default:l(()=>[t(y,{modelValue:r.form.own_mg,"onUpdate:modelValue":e[9]||(e[9]=s=>r.form.own_mg=s),label:"Do you Own an MG-HS"},null,8,["modelValue"])]),_:1}),t(i,{cols:"12"},{default:l(()=>[t(x,{onClick:m.insertRecord,disabled:r.loading,loading:r.loading,"loading-text":r.form.id>0?"Updating":"Inserting",class:"insert-record-btn"},{default:l(()=>[b(D(r.form.id>0?"Update":"Insert")+" Record",1)]),_:1},8,["onClick","disabled","loading","loading-text"])]),_:1})]),_:1})],32)]),_:1})]),_:1})}const A=U(F,[["render",P]]);export{A as default};
