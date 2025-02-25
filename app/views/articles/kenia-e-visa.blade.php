@extends('layouts.public')
@section('content')
<style>
    *,:before,:after{--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-scroll-snap-strictness: proximity;--tw-gradient-from-position: ;--tw-gradient-to-position: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(8 173 228 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: }::backdrop{--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-scroll-snap-strictness: proximity;--tw-gradient-from-position: ;--tw-gradient-to-position: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(8 173 228 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: }*,:before,:after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#b0c1c5}:before,:after{}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:Manrope,Arial,sans-serif;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}h1,h2,h3,h4{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}strong{font-weight:bolder}code{font-family:;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}button,input{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button{text-transform:none}button,input:where([type=button]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}h1,h2,h3,h4,p{margin:0}ul,menu{list-style:none;margin:0;padding:0}dialog{padding:0}input::-moz-placeholder{opacity:1;color:#426671}input::placeholder{opacity:1;color:#426671}button,[role=button]{cursor:pointer}img,svg,object{display:block;vertical-align:middle}img{max-width:100%;height:auto}[hidden]{display:none}[type=text],[type=email],[type=url],[type=date],[type=search]{-webkit-appearance:none;-moz-appearance:none;appearance:none;background-color:#fff;border-color:#0b3947;border-width:1px;border-radius:0;padding:.5rem .75rem;font-size:1rem;line-height:1.5rem;--tw-shadow: 0 0 #0000}[type=text]:focus,[type=email]:focus,[type=url]:focus,[type=date]:focus,[type=search]:focus{outline:2px solid transparent;outline-offset:2px;--tw-ring-inset: var(--tw-empty, );--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: #2563eb;--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow);border-color:#2563eb}input::-moz-placeholder{color:#0b3947;opacity:1}input::placeholder{color:#0b3947;opacity:1}::-webkit-datetime-edit-fields-wrapper{padding:0}::-webkit-date-and-time-value{min-height:1.5em;text-align:inherit}::-webkit-datetime-edit{display:inline-flex}::-webkit-datetime-edit,::-webkit-datetime-edit-year-field,::-webkit-datetime-edit-month-field,::-webkit-datetime-edit-day-field,::-webkit-datetime-edit-hour-field,::-webkit-datetime-edit-minute-field,::-webkit-datetime-edit-second-field,::-webkit-datetime-edit-millisecond-field,::-webkit-datetime-edit-meridiem-field{padding-top:0;padding-bottom:0}[type=file]{background:unset;border-color:inherit;border-width:0;border-radius:0;padding:0;font-size:unset;line-height:inherit}[type=file]:focus{outline:1px solid ButtonText;outline:1px auto -webkit-focus-ring-color}html{scroll-padding-top:6rem;font-size:16px}a,a:visited,a:active{text-decoration:none}.cj{display:grid;max-width:1312px;grid-template-columns:repeat(4,minmax(0,1fr));-moz-column-gap:16px;column-gap:16px}@media (min-width: 768px){.cj{grid-template-columns:repeat(8,minmax(0,1fr));-moz-column-gap:20px;column-gap:20px}}@media (min-width: 1200px){.cj{grid-template-columns:repeat(12,minmax(0,1fr));-moz-column-gap:32px;column-gap:32px}}.ck{margin-left:24px;margin-right:24px;max-width:1312px}@media (min-width: 768px){.ck{margin-left:48px;margin-right:48px}}@media (min-width: 1200px){.ck{margin-left:120px;margin-right:120px}}@media (min-width: 1536px){.ck{margin-left:auto;margin-right:auto}}.cl{position:fixed;height:100vh;overflow-y:scroll;transition-property:transform;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.3s;transform:translate(200%);max-height:1000px;z-index:10000}.cm{margin-left:24px;margin-right:24px}@media (min-width: 768px){.cm{margin-left:48px;margin-right:48px}}@media (min-width: 1200px){.cm{margin-left:120px;margin-right:120px}}.cn{display:none;border-radius:24px;--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity));--tw-shadow: 0px 2px 20px 0px rgba(68, 68, 68, .12);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow);z-index:1000;min-width:10rem}.cn.show{display:block}.cn{top:0}@media (min-width: 768px){.co{max-height:336px}}.cp{--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity))}.collapse:not(.show){display:none}.collapse.show{visibility:visible}a.v2-rotate-icon>svg{transform:rotate(180deg);transition:all .1s linear}.cq,.cr,.cs,.ct,.cu,.cv,.cw,.cx,.cy,.cz{min-width:0}.da{max-width:100%;overflow-x:hidden;--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity));font-size:1rem;line-height:28px}.da a:not(.db){font-size:1rem;line-height:28px;cursor:pointer;font-weight:600;--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity));text-decoration-line:underline}.da a:not(.db):hover{--tw-text-opacity: 1;color:rgb(66 102 113 / var(--tw-text-opacity))}.da a:not(.db).v2-link-blue{--tw-text-opacity: 1;color:rgb(37 56 184 / var(--tw-text-opacity))}.da a:not(.db).v2-link-blue:hover{--tw-text-opacity: 1;color:rgb(57 79 225 / var(--tw-text-opacity))}.da .markdown-no-underline a{text-decoration-line:none}.da h1{margin-bottom:32px;font-size:2rem;font-weight:600;line-height:40px}@media (min-width: 1200px){.da h1{font-size:2.75rem;font-weight:600;line-height:52px}}.da p+h1{margin-top:32px}.da h1+p{margin-top:24px}.da h2{margin-bottom:32px;margin-top:40px;font-size:1.5rem;font-weight:700;line-height:32px}.da h3{margin-bottom:16px;margin-top:32px;font-size:1.25rem;font-weight:700;line-height:28px}.da p{text-align:justify}.da p+p{margin-top:24px}.da ul,.da ol{margin-left:20px}.da ul li{margin-top:16px;margin-bottom:16px;list-style-type:disc}.da ol li{margin-top:16px;margin-bottom:16px;list-style-type:decimal}.da li.cross::marker{content:url(/vendor/icons-ivisa/solid/bullet-cross.svg) " "}.da li.check::marker{content:url(/vendor/icons-ivisa/solid/bullet-check.svg) " "}.da hr{margin-top:16px;margin-bottom:16px}.db{display:flex;align-items:center;justify-content:center;border-radius:9999px;--tw-bg-opacity: 1;background-color:rgb(0 212 116 / var(--tw-bg-opacity));padding:16px 40px;--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity));text-decoration-line:none;outline-width:2px;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s;font-size:1.125rem;font-weight:700;line-height:24px}.db:hover{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity));--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity));outline-style:solid;outline-color:#000}.db:disabled{--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity));--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity));outline-width:0px}.da table{width:100%;border-collapse:collapse;overflow-x:scroll;--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity))}.da table td:first-child,.da table th:first-child{position:sticky;left:0;--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.da table td:first-child{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.da table thead,.da table th:first-child{--tw-bg-opacity: 1;background-color:rgb(221 241 247 / var(--tw-bg-opacity))}.da table tr:nth-child(2n),.da table tr:nth-child(2n) td:first-child{--tw-bg-opacity: 1;background-color:rgb(248 249 249 / var(--tw-bg-opacity))}.da table tr{border-bottom-width:1px;--tw-border-opacity: 1;border-color:rgb(213 225 226 / var(--tw-border-opacity))}.da table td,.da table th{padding:10px;min-width:140px}.da table th{text-align:left}.da blockquote:before{content:url(/img/open-quote.svg)}.da blockquote{flex-direction:column;gap:16px;padding:20px 24px}.da blockquote p{--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity));font-size:1.5rem;line-height:32px}.da.destination-cta-wrapper{margin-top:24px;margin-bottom:40px;display:flex;width:100%;align-items:center;justify-content:space-between;gap:16px}@media (min-width: 768px){.da.destination-cta-wrapper{gap:24px}}@media (min-width: 1200px){.da.destination-cta-wrapper{justify-content:flex-start}}.da.destination-cta-wrapper a{display:flex;align-items:center;justify-content:center;border-radius:16px;--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity));outline-style:solid}.da.destination-cta-wrapper a:focus{--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000);--tw-ring-opacity: 1;--tw-ring-color: rgb(57 79 225 / var(--tw-ring-opacity));--tw-ring-offset-width: 2px}.da.destination-cta-wrapper a:disabled{--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity));background-image:none;--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity))}@media (min-width: 1200px){.da.destination-cta-wrapper a:hover{background-image:none}.da.destination-cta-wrapper a:hover:disabled{--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity));--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity));outline-color:transparent}}.da.destination-cta-wrapper a{padding:12px 24px;font-size:.875rem;font-weight:700;line-height:16px;width:100%}@media (min-width: 1200px){.da.destination-cta-wrapper a{width:auto}}.da.destination-cta-wrapper a{margin:2px;text-wrap:nowrap;--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity));font-size:1rem;font-weight:700;line-height:16px}@media (min-width: 768px){.da.destination-cta-wrapper a{padding:16px 32px;font-size:1rem;font-weight:700;line-height:16px}}.da img{margin-left:auto;margin-right:auto;border-radius:16px}.da.markdown-blue-links a{--tw-text-opacity: 1;color:rgb(37 56 184 / var(--tw-text-opacity))}.da.markdown-blue-links a:hover{--tw-text-opacity: 1;color:rgb(57 79 225 / var(--tw-text-opacity))}.da .markdown-table{margin-top:24px;margin-bottom:24px;overflow:hidden;border-radius:8px;border-width:1px;--tw-border-opacity: 1;border-color:rgb(176 193 197 / var(--tw-border-opacity))}.da .markdown-table>div{position:relative;overflow-x:scroll}input.csx,.csx:has(input[type=file]),.brj{display:block;width:100%;cursor:pointer;border-width:1px;--tw-border-opacity: 1;border-color:rgb(213 225 226 / var(--tw-border-opacity));--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity))}input.csx:focus,.csx:has(input[type=file]):focus,.brj:focus{--tw-border-opacity: 1;border-color:rgb(11 57 71 / var(--tw-border-opacity));--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000)}input.csx:enabled:hover,.csx:has(input[type=file]):enabled:hover,.brj:enabled:hover{--tw-border-opacity: 1;border-color:rgb(11 57 71 / var(--tw-border-opacity))}input.csx:disabled,.csx:has(input[type=file]):disabled,.brj:disabled{--tw-bg-opacity: 1;background-color:rgb(231 238 239 / var(--tw-bg-opacity));--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity))}.csx::-moz-placeholder{--tw-text-opacity: 1;color:rgb(176 193 197 / var(--tw-text-opacity))}.csx::placeholder{--tw-text-opacity: 1;color:rgb(176 193 197 / var(--tw-text-opacity))}input.csx.error{--tw-border-opacity: 1;border-color:rgb(255 107 96 / var(--tw-border-opacity))}.brj{border-radius:24px;padding:16px 24px;font-size:1rem;line-height:24px}.brj::-webkit-resizer{display:none}input.csx{border-radius:16px;padding:20px 16px;font-size:1rem;line-height:16px}input.csx.v2-small{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;padding-top:10px;padding-bottom:10px;padding-right:40px;line-height:20px}.csx[type=date]{position:relative;padding-right:28px}::-webkit-calendar-picker-indicator{position:absolute;right:28px;display:inline;height:20px;width:20px;--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity));background:url(/vendor/icons-ivisa/solid/calendar.svg) no-repeat}.dc{display:flex;width:100%;cursor:pointer;align-items:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;border-radius:16px;border-width:1px;--tw-border-opacity: 1;border-color:rgb(213 225 226 / var(--tw-border-opacity));--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity));padding:28px;font-size:1rem;line-height:16px}.dc:hover{--tw-border-opacity: 1;border-color:rgb(11 57 71 / var(--tw-border-opacity))}.dc:focus{--tw-border-opacity: 1;border-color:rgb(11 57 71 / var(--tw-border-opacity));outline:2px solid transparent;outline-offset:2px;--tw-ring-opacity: 1;--tw-ring-color: rgb(11 57 71 / var(--tw-ring-opacity))}.dc.v2-small{padding:10px 16px;line-height:22px}.dd{display:flex;width:100%;cursor:pointer;align-items:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;border-radius:16px;border-width:1px;--tw-border-opacity: 1;border-color:rgb(213 225 226 / var(--tw-border-opacity));--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity));padding:18px 16px;line-height:20px}.dd:hover{--tw-border-opacity: 1;border-color:rgb(11 57 71 / var(--tw-border-opacity))}.dd:focus{--tw-border-opacity: 1;border-color:rgb(11 57 71 / var(--tw-border-opacity));outline:2px solid transparent;outline-offset:2px;--tw-ring-opacity: 1;--tw-ring-color: rgb(11 57 71 / var(--tw-ring-opacity))}.de{width:100%;border-top-left-radius:16px;border-top-right-radius:16px;border-width:0;padding:20px 24px;outline-width:0px;font-size:1rem;line-height:16px}.de:focus{outline:2px solid transparent;outline-offset:2px;--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000)}.brk{margin-right:8px;height:20px;width:20px;--tw-translate-y: 2px;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));border-radius:6px;--tw-border-opacity: 1;border-color:rgb(66 102 113 / var(--tw-border-opacity));padding:0}.brk:hover{border-width:1px}.brk:focus{--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000)}.brk:active{--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000)}.brk:disabled{--tw-border-opacity: 1;border-color:rgb(176 193 197 / var(--tw-border-opacity));--tw-text-opacity: 1;color:rgb(66 102 113 / var(--tw-text-opacity))}.brk:hover:disabled{border-width:1px}.brk:checked:disabled{--tw-bg-opacity: 1;background-color:rgb(231 238 239 / var(--tw-bg-opacity));background-image:none}.brk:checked:disabled:hover{border-width:1px}.df{display:flex;align-items:center;justify-content:center;border-radius:16px;--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity));outline-style:solid}.df:focus{--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000);--tw-ring-opacity: 1;--tw-ring-color: rgb(57 79 225 / var(--tw-ring-opacity));--tw-ring-offset-width: 2px}.df:disabled{--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity));background-image:none;--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity))}@media (min-width: 1200px){.df:hover{background-image:none}.df:hover:disabled{--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity));--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity));outline-color:transparent}}.dg{background-image:linear-gradient(to right,var(--tw-gradient-stops));--tw-gradient-from: #25CBD6 var(--tw-gradient-from-position);--tw-gradient-to: rgb(37 203 214 / 0) var(--tw-gradient-to-position);--tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);--tw-gradient-to: #00EE8A var(--tw-gradient-to-position);outline-width:2px;outline-color:transparent}@media (min-width: 1200px){.dg:hover{outline-color:#000}}.dh{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity));outline-width:1px;outline-color:#000}.dh:hover{outline-width:2px;outline-color:#000}.dh:disabled{outline-color:transparent}.di{--tw-bg-opacity: 1;background-color:rgb(205 219 255 / var(--tw-bg-opacity));--tw-text-opacity: 1;color:rgb(57 79 225 / var(--tw-text-opacity));outline-width:0px}.di:hover{--tw-text-opacity: 1;color:rgb(37 56 184 / var(--tw-text-opacity))}.dj{--tw-bg-opacity: 1;background-color:rgb(0 0 0 / var(--tw-bg-opacity));--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity));outline-width:0px}.dj:hover{--tw-bg-opacity: 1;background-color:rgb(11 57 71 / var(--tw-bg-opacity));outline-width:0px}.dk{padding:16px 40px;font-size:1.125rem;font-weight:700;line-height:24px}.dl{padding:16px 32px;font-size:1rem;font-weight:700;line-height:16px}.dm{padding:12px 24px;font-size:.875rem;font-weight:700;line-height:16px}.dn{border-radius:8px;padding:8px 20px;font-size:.75rem;font-weight:700;line-height:16px}.do{border-radius:8px;padding:6px 20px;font-size:.75rem;font-weight:700;line-height:16px}.dp,.dq{width:100%}@media (min-width: 1536px){.dq{width:auto}}.dr{width:100%}@media (min-width: 1200px){.dr{width:auto}}.ds{width:100%}@media (min-width: 768px){.ds{width:auto}}.dt:hover{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity));outline-color:#fff}@media (min-width: 1200px){.du:hover{--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity));outline-color:#000}}.dv{padding:0;--tw-text-opacity: 1;color:rgb(57 79 225 / var(--tw-text-opacity));outline:2px solid transparent;outline-offset:2px}.dv:hover{--tw-text-opacity: 1;color:rgb(37 56 184 / var(--tw-text-opacity));outline:2px solid transparent;outline-offset:2px}.dv:disabled{--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity))}.dw{padding:0;--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity));outline:2px solid transparent;outline-offset:2px}.dw:hover{--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity));outline:2px solid transparent;outline-offset:2px}.dw:disabled{background-color:transparent;--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity))}.dw:hover:disabled{background-color:transparent}.dx{background-color:#000c!important;position:fixed;top:0;right:0;bottom:0;left:0;display:flex;align-items:center;justify-content:center;z-index:9999}.status .step:before{position:absolute;width:75%;--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity));content:"";height:2px;top:56px;left:-25%;z-index:1}.status .step:after{position:absolute;width:75%;--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity));content:"";height:2px;top:56px;left:50%;z-index:1}.status .step.error:before{--tw-bg-opacity: 1;background-color:rgb(8 173 228 / var(--tw-bg-opacity))}.status .step:first-child:before{content:none}.status .step:last-child:after{content:none}@media (max-width: 1200px){.status .step{width:100%}.status .step:before{content:"";width:2px;height:100%;left:31px;top:-60px}.status .step:after{content:"";width:2px;height:100%;left:31px;top:20px}.status .step .image{--tw-scale-x: .75;--tw-scale-y: .75;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}}.dy,.dy:after{height:56px;width:56px;border-radius:9999px}.dy{position:relative;display:inline-block;color:transparent;border-top:5px solid #00D474;border-right:5px solid #00D474;border-bottom:5px solid #00D474;border-left:5px solid #0B3947;animation:load8 1.5s infinite linear}@keyframes load8{0%{transform:rotate(0)}to{transform:rotate(360deg)}}.ea{pointer-events:none}.eb{position:fixed}.ec{position:absolute}.ed{position:relative}.bie{position:sticky;}.ee{top:0;right:0;bottom:0;left:0}.ef{right:-2px}.eg{bottom:0}.eh{bottom:14px}.ei{bottom:40px}.ej{bottom:80px}.ek{left:0}.el{left:50%}.em{left:100%}.en{right:0}.eo{right:16px}.ep{right:24px}.eq{right:100%}.er{top:0}.es{top:50%}.et{top:16px}.eu{top:24px}.ev{top:40px}.zi{z-index:10}.ew{z-index:20}.ex{z-index:30}.ey{z-index:50}.ez{grid-column:span 4 / span 4}.fa{grid-column:1 / -1}.fb{margin:0}.fc{margin-left:24px;margin-right:24px}.fd{margin-left:4px;margin-right:4px}.fe{margin-left:8px;margin-right:8px}.ff{margin-left:auto;margin-right:auto}.bes{margin-top:16px;margin-bottom:16px}.bif{margin-top:32px;margin-bottom:32px}.ban{margin-top:40px;margin-bottom:40px}.fg{margin-top:56px;margin-bottom:56px}.fh{margin-top:8px;margin-bottom:8px}.fi{margin-bottom:0}.fj{margin-bottom:12px}.fk{margin-bottom:16px}.fl{margin-bottom:20px}.fm{margin-bottom:24px}.fn{margin-bottom:32px}.fo{margin-bottom:4px}.fp{margin-bottom:40px}.fq{margin-bottom:48px}.fr{margin-bottom:56px}.fs{margin-bottom:8px}.a{margin-bottom:80px}.fu{margin-left:32px}.fv{margin-left:4px}.fw{margin-left:8px}.fx{margin-left:auto}.fy{margin-right:0}.fz{margin-right:12px}.bao{margin-right:24px}.bbr{margin-right:4px}.ga{margin-right:6px}.gb{margin-right:8px}.gc{margin-top:12px}.gd{margin-top:16px}.ge{margin-top:20px}.gf{margin-top:24px}.gg{margin-top:32px}.xo{margin-top:40px}.za{margin-top:48px}.gh{margin-top:56px}.gi{margin-top:6px}.gk{margin-top:8px}.gl{display:block}.gm{display:inline-block}.gn{display:inline}.go{display:flex}.gp{display:inline-flex}.gr{display:none}.big{height:50%}.gs{height:10px}.gt{height:12px}.gu{height:14px}.gv{height:16px}.gw{height:18px}.gx{height:20px}.gy{height:24px}.gz{height:28px}.ha{height:32px}.hb{height:40px}.hc{height:48px}.hd{height:56px}.he{height:6px}.hf{height:64px}.hg{height:100%}.hh{height:100vh}.hi{min-height:100%}.hj{min-height:100vh}.hk{width:1px}.hl{width:33.333333%}.hm{width:25%}.hn{width:10px}.ho{width:12px}.hp{width:120px}.hq{width:14px}.hr{width:16px}.hs{width:18px}.ht{width:66.666667%}.hu{width:20px}.hv{width:24px}.hw{width:28px}.hx{width:32px}.hy{width:80%}.hz{width:40px}.ia{width:48px}.bih{width:83.333333%}.ib{width:56px}.ic{width:64px}.id{width:auto}.zl{width:-moz-fit-content;width:fit-content}.ie{width:100%}.if{width:-moz-max-content;width:max-content}.bii{width:-moz-min-content;width:min-content}.ig{width:100vw}.ih{max-width:300px}.ii{max-width:500px}.bap{max-width:85%}.ij{flex:1 1 0%}.bik{flex:none}.ik,.il{flex-shrink:0}.im{--tw-translate-x: -50%;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.in{--tw-translate-y: -50%;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.io{--tw-translate-y: 2px;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.ip{--tw-rotate: 180deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}@keyframes v2-spin{to{transform:rotate(360deg)}}.iq{animation:v2-spin 1s linear infinite}.ir{cursor:pointer}.xq{scroll-snap-type:x var(--tw-scroll-snap-strictness)}.xr{--tw-scroll-snap-strictness: mandatory}.xs{scroll-snap-align:center}.iu{flex-direction:row}.iv{flex-direction:column}.iw{flex-wrap:nowrap}.ix{align-items:flex-start}.bgo{align-items:flex-end}.iy{align-items:center}.iz{align-items:baseline}.ja{justify-content:flex-start}.jb{justify-content:flex-end}.jc{justify-content:center}.jd{justify-content:space-between}.je{gap:16px}.jf{gap:2px}.jg{gap:24px}.jh{gap:32px}.ji{gap:4px}.brm{gap:6px}.jj{gap:8px}.zm{-moz-column-gap:16px;column-gap:16px}.jk{-moz-column-gap:20px;column-gap:20px}.bhx{-moz-column-gap:32px;column-gap:32px}.jl{row-gap:12px}.v2-space-x-12>:not([hidden])~:not([hidden]){--tw-space-x-reverse: 0;margin-right:calc(12px * var(--tw-space-x-reverse));margin-left:calc(12px * calc(1 - var(--tw-space-x-reverse)))}.v2-space-x-16>:not([hidden])~:not([hidden]){--tw-space-x-reverse: 0;margin-right:calc(16px * var(--tw-space-x-reverse));margin-left:calc(16px * calc(1 - var(--tw-space-x-reverse)))}.v2-space-x-24>:not([hidden])~:not([hidden]){--tw-space-x-reverse: 0;margin-right:calc(24px * var(--tw-space-x-reverse));margin-left:calc(24px * calc(1 - var(--tw-space-x-reverse)))}.v2-space-x-32>:not([hidden])~:not([hidden]){--tw-space-x-reverse: 0;margin-right:calc(32px * var(--tw-space-x-reverse));margin-left:calc(32px * calc(1 - var(--tw-space-x-reverse)))}.v2-space-x-8>:not([hidden])~:not([hidden]){--tw-space-x-reverse: 0;margin-right:calc(8px * var(--tw-space-x-reverse));margin-left:calc(8px * calc(1 - var(--tw-space-x-reverse)))}.v2-space-y-16>:not([hidden])~:not([hidden]){--tw-space-y-reverse: 0;margin-top:calc(16px * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(16px * var(--tw-space-y-reverse))}.v2-space-y-4>:not([hidden])~:not([hidden]){--tw-space-y-reverse: 0;margin-top:calc(4px * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(4px * var(--tw-space-y-reverse))}.v2-space-y-8>:not([hidden])~:not([hidden]){--tw-space-y-reverse: 0;margin-top:calc(8px * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(8px * var(--tw-space-y-reverse))}.jm{align-self:flex-start}.jn{align-self:center}.jo{overflow:hidden}.bil{overflow:clip}.bjn{overflow:scroll}.zo{overflow-x:auto}.xw{overflow-x:scroll}.jp{overflow-y:scroll}.jq{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.jr{white-space:nowrap}.js{border-radius:8px}.jt{border-radius:16px}.ju{border-radius:8px}.jv{border-radius:0}.jw{border-radius:9999px}.jx{border-radius:24px}.jy{border-bottom-right-radius:24px;border-bottom-left-radius:24px}.jz{border-top-right-radius:9999px;border-bottom-right-radius:9999px}.zp{border-top-left-radius:24px;border-top-right-radius:24px}.ka{border-width:1px}.kb{border-width:1px}.kc{border-width:2px}.kd{border-bottom-width:1px}.ke{border-bottom-width:1px}.brn{border-bottom-width:4px}.bro{border-left-width:1px}.kf{border-top-width:1px}.kg{--tw-border-opacity: 1;border-color:rgb(0 0 0 / var(--tw-border-opacity))}.kh{--tw-border-opacity: 1;border-color:rgb(213 225 226 / var(--tw-border-opacity))}.ki{--tw-border-opacity: 1;border-color:rgb(176 193 197 / var(--tw-border-opacity))}.bgp{--tw-border-opacity: 1;border-color:rgb(231 238 239 / var(--tw-border-opacity))}.ben{--tw-border-opacity: 1;border-color:rgb(11 57 71 / var(--tw-border-opacity))}.kj{--tw-border-opacity: 1;border-color:rgb(255 107 96 / var(--tw-border-opacity))}.kk{border-color:transparent}.kl{--tw-border-opacity: 1;border-color:rgb(255 255 255 / var(--tw-border-opacity))}.km{--tw-bg-opacity: 1;background-color:rgb(0 0 0 / var(--tw-bg-opacity))}.kn{background-color:#000000bf}.xx{--tw-bg-opacity: 1;background-color:rgb(221 241 247 / var(--tw-bg-opacity))}.ko{--tw-bg-opacity: 1;background-color:rgb(241 249 252 / var(--tw-bg-opacity))}.kp{--tw-bg-opacity: 1;background-color:rgb(0 71 82 / var(--tw-bg-opacity))}.kq{--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity))}.kr{--tw-bg-opacity: 1;background-color:rgb(176 193 197 / var(--tw-bg-opacity))}.ks{--tw-bg-opacity: 1;background-color:rgb(248 249 249 / var(--tw-bg-opacity))}.kt{--tw-bg-opacity: 1;background-color:rgb(66 102 113 / var(--tw-bg-opacity))}.ku{--tw-bg-opacity: 1;background-color:rgb(231 238 239 / var(--tw-bg-opacity))}.kv{--tw-bg-opacity: 1;background-color:rgb(11 57 71 / var(--tw-bg-opacity))}.kw{--tw-bg-opacity: 1;background-color:rgb(204 246 227 / var(--tw-bg-opacity))}.kx{--tw-bg-opacity: 1;background-color:rgb(0 212 116 / var(--tw-bg-opacity))}.ky{--tw-bg-opacity: 1;background-color:rgb(255 238 216 / var(--tw-bg-opacity))}.kz{--tw-bg-opacity: 1;background-color:rgb(255 230 224 / var(--tw-bg-opacity))}.la{--tw-bg-opacity: 1;background-color:rgb(255 107 96 / var(--tw-bg-opacity))}.lb{background-color:transparent}.lc{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity));}.ld{}.xy{-o-object-fit:cover;object-fit:cover}.le{padding:1px}.bci{padding:16px}.lf{padding:24px}.lg{padding:32px}.lh{padding:4px}.brp{padding:6px}.bim{padding-left:12px;padding-right:12px}.li{padding-left:16px;padding-right:16px}.lj{padding-left:20px;padding-right:20px}.lk{padding-left:24px;padding-right:24px}.ll{padding-left:28px;padding-right:28px}.xz{padding-left:32px;padding-right:32px}.lm{padding-left:4px;padding-right:4px}.ln{padding-top:12px;padding-bottom:12px}.lo{padding-top:14px;padding-bottom:14px}.lp{padding-top:16px;padding-bottom:16px}.lq{padding-top:18px;padding-bottom:18px}.lr{padding-top:2px;padding-bottom:2px}.ls{padding-top:20px;padding-bottom:20px}.lt{padding-top:24px;padding-bottom:24px}.lu{padding-top:4px;padding-bottom:4px}.lv{padding-top:40px;padding-bottom:40px}.lw{padding-top:48px;padding-bottom:48px}.lx{padding-top:64px;padding-bottom:64px}.ly{padding-top:8px;padding-bottom:8px}.lz{padding-bottom:12px}.ma{padding-bottom:120px}.mb{padding-bottom:16px}.mc{padding-bottom:20px}.md{padding-bottom:24px}.t{padding-left:12px}.me{padding-left:16px}.mf{padding-left:24px}.mg{padding-left:8px}.mh{padding-right:16px}.mi{padding-right:32px}.mj{padding-right:6px}.mk{padding-right:80px}.boq{padding-top:0}.ml{padding-top:16px}.mm{padding-top:24px}.ya{padding-top:40px}.mo{padding-top:56px}.mp{text-align:left}.mq{text-align:center}.mr{text-align:right}.ms{font-size:2.75rem}.mt{text-transform:uppercase}.yb{text-transform:capitalize}.mv{--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity))}.mw{--tw-text-opacity: 1;color:rgb(8 173 228 / var(--tw-text-opacity))}.bin{--tw-text-opacity: 1;color:rgb(0 113 194 / var(--tw-text-opacity))}.mx{color:inherit}.my{--tw-text-opacity: 1;color:rgb(57 79 225 / var(--tw-text-opacity))}.mz{--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity))}.na{--tw-text-opacity: 1;color:rgb(66 102 113 / var(--tw-text-opacity))}.nb{--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity))}.nc{--tw-text-opacity: 1;color:rgb(0 212 116 / var(--tw-text-opacity))}.nd{--tw-text-opacity: 1;color:rgb(38 124 105 / var(--tw-text-opacity))}.brq{--tw-text-opacity: 1;color:rgb(255 205 150 / var(--tw-text-opacity))}.ne{--tw-text-opacity: 1;color:rgb(255 159 49 / var(--tw-text-opacity))}.nf{--tw-text-opacity: 1;color:rgb(255 107 96 / var(--tw-text-opacity))}.ng{--tw-text-opacity: 1;color:rgb(197 17 3 / var(--tw-text-opacity))}.nh{color:transparent}.ni{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.nj{text-decoration-line:underline}.bho{text-decoration-line:none}.nk{--tw-shadow: 0 0 1rem rgba(0,0,0,.1);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.nl{--tw-shadow: 0px 2px 20px 0px rgba(68, 68, 68, .12);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.brr{--tw-shadow: 0px 1px 8px 0px rgba(68, 68, 68, .08);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.nm{outline-style:solid}.nn{outline-width:1px}.no{outline-color:transparent}.bhp{--tw-grayscale: grayscale(100%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.brs{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,-webkit-backdrop-filter;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter,-webkit-backdrop-filter;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}.np{transition-property:all;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}.nq{transition-property:opacity;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}.nr{transition-duration:.1s}.brt{transition-duration:.15s}.ns{transition-duration:.2s}.bru{font-size:2.75rem;font-weight:700;line-height:52px}.nt{font-size:2rem;font-weight:600;line-height:40px}.nu{font-size:2rem;font-weight:700;line-height:40px}.nv{font-size:1.5rem;font-weight:700;line-height:32px}.zz{font-size:1.25rem;font-weight:600;line-height:28px}.nw{font-size:1.25rem;font-weight:700;line-height:28px}.nx{font-size:1rem;line-height:24px}.ny{font-size:1rem;font-weight:600;line-height:24px}.ob{font-size:.875rem;font-weight:700;line-height:22px}.oc{font-size:.875rem;line-height:16px}.bio{font-size:.875rem;line-height:16px}.od{font-size:.875rem;font-weight:700;line-height:16px}.oe{font-size:.75rem;line-height:16px}.of{font-size:.75rem;font-weight:700;line-height:16px}.og{font-size:1.375rem;font-weight:600;line-height:36px}.oi{font-size:1.25rem;font-weight:600;line-height:34px}.oj{font-size:1rem;line-height:28px}.ok{font-size:1rem;font-weight:600;line-height:28px}.ol{font-size:.875rem;line-height:24px}.om{font-size:.875rem;font-weight:600;line-height:24px}.on{font-size:.875rem;font-weight:700;line-height:24px}.oo{font-size:.75rem;line-height:20px}.op{font-size:.75rem;font-weight:600;line-height:20px}.or{font-size:.75rem;line-height:20px}.or{cursor:pointer;font-weight:600;--tw-text-opacity: 1;color:rgb(11 57 71 / var(--tw-text-opacity));text-decoration-line:underline}.or:hover{--tw-text-opacity: 1;color:rgb(66 102 113 / var(--tw-text-opacity))}.\[zaraz\:ecommerce\]{zaraz:ecommerce}.\[zaraz\:set\]{zaraz:set}.\[zaraz\:track\]{zaraz:track}@media (min-width: 768px){}@media (min-width: 1200px){.bhy{display:grid;max-width:1312px;grid-template-columns:repeat(4,minmax(0,1fr));-moz-column-gap:16px;column-gap:16px}@media (min-width: 768px){.bhy{grid-template-columns:repeat(8,minmax(0,1fr));-moz-column-gap:20px;column-gap:20px}}.bhy{grid-template-columns:repeat(12,minmax(0,1fr));-moz-column-gap:32px;column-gap:32px}.cua{margin-left:24px;margin-right:24px;max-width:1312px}@media (min-width: 768px){.cua{margin-left:48px;margin-right:48px}}.cua{margin-left:120px;margin-right:120px}@media (min-width: 1536px){.cua{margin-left:auto;margin-right:auto}}}@media (min-width: 1200px){input.lg\:v2-medium.csx{padding-top:14px;padding-bottom:14px}.lg\:v2-medium.dc{padding:14px 16px;line-height:22px}}.os:hover{border-width:2px}.ot:hover{--tw-border-opacity: 1;border-color:rgb(0 0 0 / var(--tw-border-opacity))}.ou:hover{--tw-border-opacity: 1;border-color:rgb(121 148 155 / var(--tw-border-opacity))}.ov:hover{--tw-border-opacity: 1;border-color:rgb(197 17 3 / var(--tw-border-opacity))}.ow:hover{--tw-border-opacity: 1;border-color:rgb(255 255 255 / var(--tw-border-opacity))}.ox:hover{--tw-bg-opacity: 1;background-color:rgb(231 238 239 / var(--tw-bg-opacity))}.oy:hover{background-color:transparent}.oz:hover{--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity))}.pa:hover{--tw-text-opacity: 1;color:rgb(197 17 3 / var(--tw-text-opacity))}.pb:hover{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.pc:hover{text-decoration-line:underline}.pd:hover{outline-color:#000}.bhq:hover{--tw-grayscale: grayscale(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.pe:focus{outline-color:#00d474}.pf:focus{--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000)}.pg:disabled{border-color:transparent}.ph:disabled{--tw-bg-opacity: 1;background-color:rgb(213 225 226 / var(--tw-bg-opacity))}.pi:disabled{--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity))}.disabled\:hover\:v2-border-1:hover:disabled{border-width:1px}.disabled\:hover\:v2-border-transparent:hover:disabled{border-color:transparent}.disabled\:hover\:v2-text-gray-300:hover:disabled{--tw-text-opacity: 1;color:rgb(121 148 155 / var(--tw-text-opacity))}@media (min-width: 768px){.pm{position:fixed}.brv{top:56px}.pn{top:64px}.pu{margin-left:4px;margin-right:4px}.pv{margin-bottom:-64px}.pw{margin-bottom:0}.cuc{margin-bottom:40px}.qa{margin-top:0}.qb{margin-top:56px}.qc{margin-top:64px}.qd{margin-top:96px}.qe{display:block}.qf{display:inline}.qg{display:flex}.qi{display:none}.qj{height:10px}.qk{height:12px}.ql{height:14px}.qm{height:16px}.qn{height:18px}.qo{height:20px}.qp{height:24px}.qq{height:28px}.qr{height:32px}.qs{height:40px}.qt{height:48px}.qu{height:64px}.qv{height:auto}.bia{width:50%}.qx{width:10px}.qy{width:12px}.qz{width:14px}.ra{width:16px}.rb{width:18px}.rc{width:66.666667%}.rd{width:20px}.re{width:24px}.rf{width:28px}.rg{width:32px}.rh{width:40px}.ri{width:48px}.rj{width:41.666667%}.rk{width:64px}.rl{width:153px}.rm{width:auto}.rr{flex-direction:row}.rt{align-items:center}.ru{justify-content:flex-start}.rv{justify-content:flex-end}.rw{justify-content:space-between}.md\:v2-space-x-24>:not([hidden])~:not([hidden]){--tw-space-x-reverse: 0;margin-right:calc(24px * var(--tw-space-x-reverse));margin-left:calc(24px * calc(1 - var(--tw-space-x-reverse)))}.md\:v2-space-x-32>:not([hidden])~:not([hidden]){--tw-space-x-reverse: 0;margin-right:calc(32px * var(--tw-space-x-reverse));margin-left:calc(32px * calc(1 - var(--tw-space-x-reverse)))}.md\:v2-space-y-0>:not([hidden])~:not([hidden]){--tw-space-y-reverse: 0;margin-top:calc(0px * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0px * var(--tw-space-y-reverse))}.sc{border-radius:24px}.sj{padding-top:12px;padding-bottom:12px}.sk{padding-top:32px;padding-bottom:32px}.sl{padding-top:4px;padding-bottom:4px}.sn{padding-bottom:24px}.so{padding-bottom:48px}.sp{padding-bottom:56px}.sr{padding-top:56px}.cul{padding-top:64px}.su{font-size:2rem;font-weight:700;line-height:40px}.sv{font-size:1.5rem;font-weight:600;line-height:32px}.sw{font-size:.875rem;line-height:24px}}@media (min-width: 1200px){.sx{bottom:14px}.sy{z-index:50}.ta{grid-column:span 2 / span 2}.tb{grid-column:span 3 / span 3}.tc{grid-column:span 4 / span 4}.td{grid-column:span 5 / span 5}.te{grid-column:span 6 / span 6}.tf{grid-column:span 7 / span 7}.th{grid-column-start:11}.tj{grid-column-start:5}.yi{grid-column-start:6}.tk{grid-column-start:7}.bfk{grid-column-end:13}.tl{margin-left:32px;margin-right:32px}.tm{margin-top:0;margin-bottom:0}.brw{margin-top:96px;margin-bottom:96px}.tn{margin-bottom:0}.zg{margin-bottom:32px}.bep{margin-bottom:40px}.bar{margin-right:0}.tr{margin-right:16px}.tt{margin-top:0}.zh{margin-top:40px}.tu{margin-top:48px}.bix{}.tv{margin-top:64px}.tw{margin-top:96px}.tx{display:block}.ty{display:inline}.tz{display:flex}.ua{display:grid}.ub{display:none}.uc{height:10px}.ud{height:12px}.ue{height:14px}.uf{height:16px}.ug{height:18px}.uh{height:20px}.ui{height:24px}.uj{height:28px}.uk{height:32px}.ul{height:40px}.um{height:48px}.un{height:64px}.uq{width:33.333333%}.bqd{width:25%}.ur{width:10px}.us{width:12px}.ut{width:14px}.uu{width:16px}.uv{width:18px}.uw{width:20px}.ux{width:24px}.uy{width:28px}.uz{width:32px}.va{width:40px}.vb{width:48px}.vc{width:41.666667%}.vd{width:64px}.ve{width:547px}.bid{width:auto}.vf{max-width:450px}.vg{cursor:default}.bat{grid-template-columns:repeat(3,minmax(0,1fr))}.vi{flex-direction:row}.bbf{flex-direction:column}.vk{align-items:center}.brx{justify-content:flex-start}.vl{justify-content:space-between}.vm{gap:24px}.vn{gap:32px}.vo{-moz-column-gap:0;column-gap:0}.vp{-moz-column-gap:24px;column-gap:24px}.vr{justify-self:end}.bry{overflow:hidden}.vs{padding:40px}.bau{padding-left:20px;padding-right:20px}.vu{padding-left:48px;padding-right:48px}.vv{padding-top:0;padding-bottom:0}.vw{padding-top:10px;padding-bottom:10px}.bag{padding-top:24px;padding-bottom:24px}.vx{padding-bottom:0}.vy{padding-bottom:16px}.vz{padding-bottom:56px}.wa{padding-bottom:6px}.brz{padding-top:14px}.yv{text-align:left}.ca{font-size:2.75rem;font-weight:600;line-height:52px}.wd{font-size:1.5rem;font-weight:700;line-height:32px}.bsa{font-size:1.25rem;line-height:28px}.baw{font-size:1.25rem;font-weight:600;line-height:28px}.we{font-size:1rem;line-height:24px}.wf{font-size:1rem;font-weight:700;line-height:24px}.wh{font-size:1rem;line-height:28px}}@media (min-width: 1536px){.wi{margin-top:48px}.wj{height:10px}.wk{height:12px}.wl{height:14px}.wm{height:16px}.wn{height:18px}.wo{height:20px}.wp{height:24px}.wq{height:28px}.wr{height:32px}.ws{height:40px}.wt{height:48px}.wu{height:64px}.wv{width:25%}.ww{width:10px}.wx{width:12px}.wy{width:14px}.wz{width:16px}.xa{width:18px}.xb{width:20px}.xc{width:24px}.xd{width:28px}.xe{width:32px}.xf{width:40px}.xg{width:48px}.xh{width:64px}.xi{max-width:none}.xj{padding-top:0;padding-bottom:0}}

</style>
<div>
    <div class="bie er brv cuc tn lc zi">
        <div class="bix ub brr ly li go je iy jd kd bgp nb">
            <div>
                <div class="ny">Kenya ETA</div>
            </div>
            <a href="/a/kenia" tabindex="-1">

                <button class="df dg dm du" data-handle="lm-apply-now-button-mobile" type="submit" onclick="setVisaType()">

                    Aplica ahora
                </button>

            </a>
        </div>
        <div class="nl">
            <nav class="bix cua brz boq go jd nb">
                <ul class="go bio jr bjn bry" style="scrollbar-width: none" id="sections" aria-label="Section Navigation"><li><button class="li lp bag ir brn ox bio brs brt hg kk" id="learn-nav" aria-label="Go to the Más información section">Más información</button></li><li><button class="li lp bag ir brn ox bio brs brt hg kk" id="apply-nav" aria-label="Go to the Cómo solicitarlo section">Cómo solicitarlo</button></li><li><button class="li lp bag ir brn ox bio brs brt hg ben od" id="faqs-section-nav" aria-label="Go to the Preguntas section">Preguntas</button></li></ul>

                <div class="gr tz iy v2-space-x-32 lz">
                    <div class="ny mr iv go bgo">
                        <div>Kenya ETA</div>
                    </div>
                    <div class="jr">
                        <a href="/a/kenia" tabindex="-1">

                            <button class="df dg dl dr du" data-handle="lm-apply-now-button" type="submit" onclick="setVisaType()">

                                Aplica ahora
                            </button>

                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>


    <section id="learn">
        <div class="ck ya cul">

            <h1 class="mq fp bru nb">Obtén en línea tu hora prevista de llegada a Kenia de forma rápida y sencilla</h1>


            <div class="da">
                <div class="ko jx xz ly fp">
                    <h3 id="instructions_header" class="text-black">
                        Lo que debes saber        </h3>
                    <div id="instructions_body">
                        <ul>
                            <li>
                                <p>Permite ingresar una sola vez y permanecer hasta un máximo de 90 días en Kenia.</p>
                            </li>
                            <li>
                                <p>Debes presentar la solicitud al menos 3 días antes de la fecha de tu viaje.</p>
                            </li>
                            <li>
                                <p>Algunos documentos requeridos para la solicitud de la ETA de Kenia incluyen tu pasaporte vigente, una foto, confirmación de tu vuelo y comprobante de alojamiento, además de la justificación de los motivos de tu viaje (ver lista completa a continuación).</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="jt lp lk tz jd iy nb ka kh markdown-no-underline">
                    <div class="go je vm fk tn">
                        <div class="go ix vk il">
                            <img data-src="https://d1bfs3rtmjstvi.cloudfront.net/img/v2/visa-green.png" alt="passport icon" width="50" height="50" data-ll-status="loaded" class="entered loaded" src="https://d1bfs3rtmjstvi.cloudfront.net/img/v2/visa-green.png">
                        </div>
                        <div>
                            <div class="nw fo">¿Tienes dudas sobre si esta es la visa que necesitas?</div>
                            <div class="oj">Proporciona algunos detalles sobre tu viaje y te ayudaremos a encontrar la visa correcta.</div>
                        </div>
                    </div>

                    <a href="https://ivisaviajes.com/KE/visa-match" tabindex="-1">

                        <button class="df dh dl dr du" type="submit">

                            Encuentra la visa que mejor se adapta a ti
                        </button>

                    </a>
                </div>

                <h2 id="solicita-hoy-mismo-la-eta-de-kenia-con-nosotros">¡Solicita hoy mismo la ETA de Kenia con nosotros!</h2>
                <p><strong>Última actualización: marzo de 2024</strong></p>
                <p>¡Deslumbrante con la fascinante belleza de Kenia! Prepárate para explorar el corazón de África con la Autorización Electrónica de Viaje (ETA) de Kenia.</p>
                <p><img data-zoom-image="" data-src="https://d2kzh91pcly9gn.cloudfront.net/masai-kenya-natural-view.webp" alt="Fill me in" data-ll-status="loaded" class="entered loaded" src="https://d2kzh91pcly9gn.cloudfront.net/masai-kenya-natural-view.webp">  </p>
                <p>Hemos simplificado el proceso de solicitud de la <a href="/a/kenia" target="_blank" rel="nofollow">ETA de Kenia</a> con esta práctica guía en línea.</p>
                <h2 id="que-es-la-eta-de-kenia">¿Qué es la ETA de Kenia?</h2>
                <p>La <strong>ETA de Kenia</strong> es un documento diseñado para viajeros internacionales que deseen visitar Kenia.</p>
                <p>Esta <strong>Autorización Electrónica de Viaje (ETA) de Kenia</strong> sustituye a la eVisa de Kenia. A diferencia de la eVisa, que es una versión completamente digital de una visa tradicional, la ETA es un registro que se realiza antes de la llegada. El proceso es más rápido y sencillo que el de una solicitud de visa convencional.</p>
                <h3>¿Qué puedo hacer con la ETA de Kenia?</h3>
                <p>Este documento te permite hacer lo siguiente:</p>
                <ul>
                    <li>Turismo</li>
                    <li>Actividades comerciales, asistir a conferencias</li>
                    <li>Visitar amigos y familiares</li>
                    <li>Permite que la tripulación de aviones/barcos (incluidos los barcos de pesca) entre al país</li>
                    <li>Visita oficial de un diplomático</li>
                    <li>Atención médica</li>
                    <li>Visita religiosa</li>
                    <li>Estudio/Educación</li>
                    <li>Tránsito</li>
                </ul>
                <h3>¿Qué no puedo hacer con la ETA de Kenia?</h3>
                <p>La ETA está destinada únicamente a visitas breves y no autoriza la residencia en Kenia.</p>
                <h2 id="quien-puede-solicitar-la-eta-de-kenia">¿Quién puede solicitar la ETA de Kenia?</h2>
                <p><strong>Todos los visitantes</strong>, a excepción de aquellos provenientes de los estados de la Comunidad del África Oriental (CAO), deben obtener la ETA antes de ingresar al país.</p>
                <h3>¿Quién no necesita solicitar la ETA de Kenia para ingresar al país?</h3>
                <p>Los ciudadanos de los estados de la Comunidad de África Oriental (CAO) están <strong>exentos de solicitar la ETA de Kenia</strong>:</p>
                <ul>
                    <li>República Democrática del Congo</li>
                    <li>Burundi</li>
                    <li>Ruanda</li>
                    <li>Sudán del Sur</li>
                    <li>Uganda</li>
                    <li>Tanzania</li>
                </ul>
                <h3>¿Los menores de edad también deben solicitar la ETA de Kenia?</h3>
                <p><strong>Sí, los niños/menores de edad también deben solicitar la ETA para visitar Kenia.</strong> Los padres/tutores legales pueden solicitarla a su nombre.</p>
                <h2 id="por-cuanto-tiempo-es-valida-la-eta-de-kenia">¿Por cuánto tiempo es válida la ETA de Kenia?</h2>
                <p>Puedes visitar Kenia <strong>una vez</strong> con la ETA y <strong>permanecer hasta <strong>90 días después de emitirse</strong></strong>.</p>
                <p>Debes solicitarla <strong>al menos 3 días antes de la fecha de tu viaje</strong>.</p>
                <h3>¿Puedo extender la duración de la ETA de Kenia?</h3>
                <p>La <strong>ETA no es extensible</strong>. Si deseas quedarte más tiempo, simplemente asegúrate de salir del país antes de que expire tu ETA y solicita una nueva. ¡Con nosotros puedes obtenerla en solo unos días!</p>
                <h2 id="documentos-requeridos-para-solicitar-la-eta-de-kenia">Documentos requeridos para solicitar la ETA de Kenia</h2>
                <p>Estos son los documentos necesarios para solicitar tu ETA:</p>
                <h3>Para todos los solicitantes</h3>
                <ul>
                    <li>
                        <p><strong>Escaneo del pasaporte:</strong> Necesitamos un escaneo de alta calidad de tu pasaporte. Asegúrate de que tenga una validez de al menos 6 meses después de tu llegada a Kenia y que cuente con dos páginas en blanco para los sellos de entrada y salida.</p>
                    </li>
                    <li>
                        <p><strong>Una fotografía reciente tuya:</strong> Esta debe haber sido tomada en los últimos 3 meses. Puede ser un selfie o una de tipo pasaporte.</p>
                    </li>
                    <li>
                        <p><strong>Confirmación de reserva de vuelo/crucero:</strong> Es necesario proporcionar el número de vuelo de llegada y las fechas de ida y vuelta. Además, incluye cualquier información de viaje relevante sobre vuelos de conexión (en caso los haya).</p>
                    </li>
                    <li>
                        <p><strong>Comprobante de alojamiento:</strong> Si tienes reservado un hotel, adjunta la confirmación de tu reserva. En caso de alojarte con familiares o amigos, proporciona una carta de invitación junto con una copia de la identificación del anfitrión.</p>
                    </li>
                </ul>
                <h3>Para empresarios y trabajadores</h3>
                <ul>
                    <li>
                        <p><strong>Carta del empleador:</strong> Si viajas por negocios. Esta carta puede provenir de una agencia, empresa o empleador y justifica tu presencia en Kenia, confirmando tu situación laboral y proporcionando información de contacto de la empresa anfitriona.</p>
                    </li>
                    <li>
                        <p><strong>Identificación de tripulación o Libreta de Marino:</strong> Necesario para tripulaciones de aviones o barcos, así como para marinos que ingresan al país.</p>
                    </li>
                </ul>
                <h3>Visita diplomática u oficial</h3>
                <ul>
                    <li>
                        <p><strong>Carta de misión:</strong> Para asuntos oficiales o tránsito a través de Kenia hacia otro país por razones oficiales o deberes, proporciona una carta oficial del país de origen, organización o entidad extranjera correspondiente.</p>
                    </li>
                    <li>
                        <p><strong>Copia de la portada del pasaporte (pasaporte oficial/diplomático)</strong></p>
                    </li>
                </ul>
                <h3>Atención médica</h3>
                <ul>
                    <li><strong>Carta de referencia médica:</strong> Una carta proporcionada por un médico o institución médica que justifique tu visita a Kenia por razones de atención médica.</li>
                </ul>
                <h3>Estudio/razones educativas</h3>
                <ul>
                    <li><strong>Carta de admisión de la escuela/universidad:</strong> </li>
                </ul>
                <h3>Interrupción de viaje/viaje no planificado</h3>
                <ul>
                    <li>
                        <p><strong>Carta de la aerolínea:</strong> Una comunicación oficial emitida por tu aerolínea que informe sobre cualquier interrupción en tu viaje.</p>
                    </li>
                    <li>
                        <p><strong>Tarjeta de embarque:</strong> Tarjeta de embarque original.</p>
                    </li>
                </ul>
                <h2 id="como-solicitar-la-eta-de-kenia-con-nosotros">Cómo solicitar la ETA de Kenia con nosotros</h2>
                <p>La solicitud de la ETA de Kenia es muy fácil de completar y lleva solo <strong>15 minutos</strong>. Solo debes seguir estos sencillos pasos:</p>
                <ul>
                    <li>
                        <p><strong>Paso 1:</strong> Ingresa tus datos personales y de viaje en nuestra plataforma o <a href="/download">aplicación móvil</a>.</p>
                    </li>
                    <li>
                        <p><strong>Paso 2:</strong> Elige el tiempo de procesamiento que prefieras y paga las tarifas con tarjeta de crédito/débito, Venmo o PayPal.</p>
                    </li>
                    <li>
                        <p><strong>Paso 3:</strong> Después de completar el pago, sube los documentos requeridos y aguarda la confirmación de tu ETA en tu correo electrónico.</p>
                    </li>
                </ul>
                <p>Una vez aprobada, puedes <strong>imprimir el PDF o descargarlo en tu dispositivo móvil</strong>. Al llegar a Kenia, solo debes presentar tu ETA junto con tu pasaporte.</p>
                <h2 id="costos-y-tiempos-de-procesamiento-de-la-eta-de-kenia">Costos y tiempos de procesamiento de la ETA de Kenia</h2>
                <p>Las tarifas se componen de dos partes:</p>
                <ul>
                    <li>
                        <p><strong>Tarifa gubernamental de la ETA de Kenia:</strong> <strong>USD $35.00</strong></p>
                    </li>
                    <li>
                        <p><strong>Tarifa de servicio de iVisa:</strong> Varía según el tiempo de procesamiento que elijas.</p>
                    </li>
                </ul>
                <p>Generalmente ofrecemos tres tiempos de procesamiento diferentes. Elige la opción que mejor se adapte a tus necesidades y presupuesto:</p>
                <ul>
                    <li>
                        <p><strong>Estándar:</strong> Ideal para aquellos que han planificado su viaje a Kenia con antelación. Esta es la opción más económica y suele tardar unos días en procesarse.</p>
                    </li>
                    <li>
                        <p><strong>Rápido:</strong> Si necesitas tu ETA con urgencia, elige nuestro servicio “rápido” para obtenerla antes que con la opción estándar, por una tarifa adicional.</p>
                    </li>
                    <li>
                        <p><strong>Urgente:</strong> Para aquellos viajeros que necesitan su ETA con urgencia, esta opción es la más adecuada. </p>
                    </li>
                </ul>
                <p>Por favor, verifica las tarifas específicas para tu nacionalidad al <a href="/a/kenia" target="_blank" rel="nofollow">iniciar tu solicitud</a> ahora mismo.</p>
                <h2 id="necesito-solicitar-la-eta-de-kenia-para-hacer-transito-por-el-pais">¿Necesito solicitar la ETA de Kenia para hacer tránsito por el país?</h2>
                <p>No es necesario que la solicites si permaneces <strong>en el aeropuerto durante una escala</strong>. Sin embargo, es posible que necesites una Visa de Tránsito o ETA si planeas abandonar el aeropuerto y entrar al país antes de continuar tu viaje hacia otro destino.</p>
                <h2 id="requisitos-o-restricciones-de-entrada-a-kenia">Requisitos o restricciones de entrada a Kenia</h2>
                <p>Además de la ETA, hay algunas otras regulaciones que debes tener en cuenta:</p>
                <ul>
                    <li>
                        <p>La <strong>ETA de Kenia</strong> suplantará a la eVisa de Kenia, pero los viajeros que ya tengan una visa válida podrán seguir utilizando su visa hasta su fecha de vencimiento.</p>
                    </li>
                    <li>
                        <p>Es <strong>ilegal importar o exportar drones</strong> sin la aprobación previa de la <a href="https://www.kcaa.or.ke/" target="_blank" rel="nofollow">Autoridad de Aviación Civil de Kenia (KCAA)</a>. Te recomendamos comunicarte con ellos con suficiente antelación antes de tu viaje si planeas llevar un dron a Kenia.</p>
                    </li>
                    <li>
                        <p>A los viajeros mayores de 9 meses que llegan de <a href="https://www.who.int/docs/default-source/documents/emergencies/travel-advice/yellow-fever-vaccination-requirements-country-list-2020-en.pdf" target="_blank" rel="nofollow">países con riesgo de transmisión de fiebre amarilla</a> se les exige presentar un certificado de vacunación contra la fiebre amarilla.</p>
                    </li>
                    <li>
                        <p>Actualmente, no hay restricciones ni normativas relacionadas con el COVID-19 para ingresar al país.</p>
                    </li>
                </ul>
                <h2 id="necesitas-mas-informacion">¿Necesitas más información?</h2>
                <p>Si tienes alguna pregunta sobre la ETA de Kenia o necesitas información sobre viajes a otros destinos, no dudes en ponerte en contacto con nuestro equipo de atención al cliente a través de nuestro <a href="/contact-us" target="_blank" rel="nofollow">chat en línea</a> o por <a href="https://wa.link/fq9at3" target="_blank" rel="nofollow">WhatsApp</a>.</p>  </div>

        </div>
    </section>



    <section id="apply" class="fg brw">
        <div id="how-to-apply" class="how-to-apply-visa-js ck">
            <h2 class="nu fp nb mq">
                Cómo solicitarlo: ETA
            </h2>
            <div class="go iv vi jg vn iy jc">
                <div class="ie hi bqd lg jx ko nb mq">
                    <div>
                        <div class="jw hd ib lc ff fs nu go iy jc">01</div>
                        <div class="oi fo">
                            Completa nuestro formulario en línea
                        </div>
                        <p class="ol">
                            Rellena nuestra sencilla aplicación con tus datos de viaje y paga con tarjeta de crédito o Paypal.
                        </p>
                    </div>
                </div>
                <div class="ie hi bqd lg jx ko nb mq">
                    <div>
                        <div class="jw hd ib lc ff fs nu go iy jc">02</div>
                        <div class="oi fo">
                            Recibe tu documento por correo electrónico
                        </div>
                        <p class="ol">
                            Te enviamos tu visa 100% online, sin necesidad de acudir a la embajada.
                        </p>
                    </div>
                </div>
                <div class="ie hi bqd lg jx ko nb mq">
                    <div>
                        <div class="jw hd ib lc ff fs nu go iy jc">03</div>
                        <div class="oi fo">
                            Ingresa a tu destino
                        </div>
                        <p class="ol">
                            Presenta tu pasaporte y tu e-visa cuando llegues a tu país de destino.
                        </p>
                    </div>
                </div>
            </div>

            <div class="gr tz jc zh">
                <a href="/a/kenia" tabindex="-1">

                    <button class="df dg dl du" type="submit">

                        Aplica ahora
                    </button>

                </a>
            </div>
        </div>
        <section class="ck">
            <div id="how-to-apply" class="gr how-to-apply-embassy-js">
                <h2 class="nu fp nb mq">
                    Cómo solicitarlo: Inscripción en la embajada    </h2>

                <div class="go iv vi jg vn iy jc">
                    <div class="ie uq lg jx ko nb mq">
                        <div class="jw hd ib lc ff fs nu go iy jc">01</div>
                        <div class="oi fo">
                            Rellena la solicitud online    </div>
                        <p class="ol">
                            Rellena nuestra sencilla solicitud en línea y paga con tarjeta de crédito o PayPal    </p>
                    </div>
                    <div class="ie uq lg jx ko nb mq">
                        <div class="jw hd ib lc ff fs nu go iy jc">02</div>
                        <div class="oi fo">
                            Viaja con seguridad    </div>
                        <p class="ol">
                            Tu embajada te ayudará si se produce una emergencia (por ejemplo, catástrofes naturales, disturbios civiles, etc.)    </p>
                    </div>
                </div>

                <div class="gr tz jc zh">
                    <a href="/a/kenia" tabindex="-1">

                        <button class="df dg dl du" type="submit">

                            Aplica ahora
                        </button>

                    </a>
                </div>
            </div>

            <div class="gr how-to-apply-embassy-js">
                <h2 class="nt ca ban nb mq">Por qué inscribirse en la Embajada</h2>

                <div class="fp oj nb">
                    El Registro de Viajes es un servicio proporcionado por el gobierno. Este servicio te permite registrar información sobre tu próximo viaje al extranjero en el Departamento de Estado para que pueda usarse para asistirte en caso de emergencia. Las personas que residen en el extranjero también pueden recibir información rutinaria de su embajada o consulado más cercano si están registradas.    </div>
                <div class="nb mq yv">
                    <h2 class="nv fm">Información requerida para aplicar</h2>
                    <p class="oj fm">
                        Una vez que te hayas registrado en tu embajada o consulado, tendrás que actualizar tus datos si:
                    </p>
                    <ul class="da t">
                        <li>cambian tus datos de contacto,</li>
                        <li>cambia tu estado civil,</li>
                        <li>vuelves a tu país de origen.</li>
                    </ul>
                </div>
            </div>
        </section>
    </section>

    <section id="related-articles-section">
        <div class="ck">
            <div class="gh tw">
                <div class="go fo go jd iy">
                    <h2 class="nu nb">Artículos relacionados</h2>
                    <div class="gr qe il">
                        <a href="/kenia/c" tabindex="-1">

                            <button class="df dh dn dr du" type="submit">

                                Leer más
                            </button>

                        </a>
                    </div>
                </div>
                <div class="go v2-flex-no-wrap zl ua bat bhx ban ly xw jd">
                    <article class="bik bih bia bid nl jx bil ie  ">
                        <a href="https://ivisaviajes.com/kenia/c/visa-keniana-para-colombianos" class="gl hg">
                            <div class="big">
                                <img class="xy hg zp ie entered loaded" data-src="https://s3.ivisa.com/website-assets/blog/kenya2.jpg" alt="VISA KENIANA PARA COLOMBIANOS cover image" width="425" height="200" data-ll-status="loaded" src="https://s3.ivisa.com/website-assets/blog/kenya2.jpg">
                            </div>
                            <div class="lg">
                                <div class="fj xx bin od jw bii bim lu">Artículo</div>
                                <h4 class="zz nb">VISA KENIANA PARA COLOMBIANOS</h4>
                            </div>
                        </a>
                    </article>
                    <article class="bik bih bia bid nl jx bil ie gr qe ">
                        <a href="https://ivisaviajes.com/kenia/c/visitar-kenia-sin-visa-guia-para-los-viajeros-que-no-necesitan-visa" class="gl hg">
                            <div class="big">
                                <img class="xy hg zp ie entered loaded" data-src="https://ivisa.s3.amazonaws.com/website-assets/blog/kenya-passport-document-travel.webp" alt="Visitar Kenia sin visa: Guía para los viajeros que no necesitan visa cover image" width="425" height="200" data-ll-status="loaded" src="https://ivisa.s3.amazonaws.com/website-assets/blog/kenya-passport-document-travel.webp">
                            </div>
                            <div class="lg">
                                <div class="fj xx bin od jw bii bim lu">Artículo</div>
                                <h4 class="zz nb">Visitar Kenia sin visa: Guía para los viajeros que no necesitan visa</h4>
                            </div>
                        </a>
                    </article>
                </div>
                <div class="qi ie bif">
                    <a href="/kenia/c" tabindex="-1">

                        <button class="df dh dl dq du" type="submit">

                            Leer más
                        </button>

                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="faqs-section">
        <div class="a">
            <div class="ck gh tw" style="min-height:900px">
                <a class="anchor-margin" id="faqs"></a>
                <h2 class="nu nb fm bep mq">¿Tienes preguntas?</h2>

                <div class="show active xo" id="eVisaFaq" role="tabpanel" aria-labelledby="faqs">
                    <div class="ie fr bao bar">
                        <div class="kd kh lt bau">
                            <a class="go iy jd" href="javascript:void(0)" data-collapse-btn="" role="button" aria-expanded="false" aria-controls="collapseFaq1" onclick="window.ivisalog.track('faq_click', {
               faq_text: 'Mi solicitud no pudo completarse debido a un error. ¿Qué debo hacer?'
             })">
                                <h3 class="ny baw nb bap">Mi solicitud no pudo completarse debido a un error. ¿Qué debo hacer?</h3>
                                <svg class="gl nb hu gx" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.29389 13.7081C9.68443 14.0986 10.3187 14.0986 10.7092 13.7081L16.7081 7.70924C17.0986 7.31869 17.0986 6.68444 16.7081 6.29389C16.3175 5.90334 15.6833 5.90334 15.2927 6.29389L10 11.5866L4.70728 6.29701C4.31673 5.90646 3.68248 5.90646 3.29193 6.29701C2.90139 6.68756 2.90139 7.32181 3.29193 7.71236L9.29076 13.7112L9.29389 13.7081Z"></path>
                                </svg>

                            </a>
                            <div class="collapse" id="collapseFaq1">
                                <div class="da nb mm">
                                    No te preocupes. Ponte en contacto con <a href="/contact-us" target="_blank" rel="nofollow">nuestro equipo de atención al cliente</a> lo antes posible, y estarán encantados de ayudarte a resolver el problema. <strong>Nuestros expertos están disponibles las 24 horas, los 7 días de la semana</strong>.        </div>
                            </div>
                        </div>
                        <div class="kd kh lt bau">
                            <a class="go iy jd" href="javascript:void(0)" data-collapse-btn="" role="button" aria-expanded="false" aria-controls="collapseFaq2" onclick="window.ivisalog.track('faq_click', {
               faq_text: 'Mi solicitud de eVisa para Kenia ha sido rechazada. ¿Qué debo hacer ahora?'
             })">
                                <h3 class="ny baw nb bap">Mi solicitud de eVisa para Kenia ha sido rechazada. ¿Qué debo hacer ahora?</h3>
                                <svg class="gl nb hu gx" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.29389 13.7081C9.68443 14.0986 10.3187 14.0986 10.7092 13.7081L16.7081 7.70924C17.0986 7.31869 17.0986 6.68444 16.7081 6.29389C16.3175 5.90334 15.6833 5.90334 15.2927 6.29389L10 11.5866L4.70728 6.29701C4.31673 5.90646 3.68248 5.90646 3.29193 6.29701C2.90139 6.68756 2.90139 7.32181 3.29193 7.71236L9.29076 13.7112L9.29389 13.7081Z"></path>
                                </svg>

                            </a>
                            <div class="collapse" id="collapseFaq2">
                                <div class="da nb mm">
                                    <p>iVisa <strong>revisa tus documentos</strong> y te brinda asistencia durante todo el proceso de solicitud para evitar posibles rechazos. Sin embargo, en ocasiones, esto puede no ser suficiente y el gobierno de Kenia podría decidir rechazar o cancelar tu solicitud de visa. En tales casos, tienes derecho a un <strong>reembolso completo de la tarifa de procesamiento de iVisa</strong> correspondiente al número de solicitantes cuya solicitud haya sido rechazada. Ten en cuenta que no realizamos reembolsos de las tasas gubernamentales.</p>
                                    <p>Si tu solicitud de eVisa para Kenia ha sido cancelada o rechazada, considera la posibilidad de volver a presentarla, dependiendo de las razones específicas de la cancelación o el rechazo.</p>        </div>
                            </div>
                        </div>
                        <div class="kd kh lt bau">
                            <a class="go iy jd" href="javascript:void(0)" data-collapse-btn="" role="button" aria-expanded="false" aria-controls="collapseFaq3" onclick="window.ivisalog.track('faq_click', {
               faq_text: '¿Mi historial criminal representa un problema?'
             })">
                                <h3 class="ny baw nb bap">¿Mi historial criminal representa un problema?</h3>
                                <svg class="gl nb hu gx" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.29389 13.7081C9.68443 14.0986 10.3187 14.0986 10.7092 13.7081L16.7081 7.70924C17.0986 7.31869 17.0986 6.68444 16.7081 6.29389C16.3175 5.90334 15.6833 5.90334 15.2927 6.29389L10 11.5866L4.70728 6.29701C4.31673 5.90646 3.68248 5.90646 3.29193 6.29701C2.90139 6.68756 2.90139 7.32181 3.29193 7.71236L9.29076 13.7112L9.29389 13.7081Z"></path>
                                </svg>

                            </a>
                            <div class="collapse" id="collapseFaq3">
                                <div class="da nb mm">
                                    Si has sido condenado penalmente, esto <strong>puede ser motivo de rechazo de la solicitud de visa</strong>.        </div>
                            </div>
                        </div>
                        <div class="kd kh lt bau">
                            <a class="go iy jd" href="javascript:void(0)" data-collapse-btn="" role="button" aria-expanded="false" aria-controls="collapseFaq4" onclick="window.ivisalog.track('faq_click', {
               faq_text: '¿La obtención de una visa asegura que podré ingresar a Kenia?'
             })">
                                <h3 class="ny baw nb bap">¿La obtención de una visa asegura que podré ingresar a Kenia?</h3>
                                <svg class="gl nb hu gx" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.29389 13.7081C9.68443 14.0986 10.3187 14.0986 10.7092 13.7081L16.7081 7.70924C17.0986 7.31869 17.0986 6.68444 16.7081 6.29389C16.3175 5.90334 15.6833 5.90334 15.2927 6.29389L10 11.5866L4.70728 6.29701C4.31673 5.90646 3.68248 5.90646 3.29193 6.29701C2.90139 6.68756 2.90139 7.32181 3.29193 7.71236L9.29076 13.7112L9.29389 13.7081Z"></path>
                                </svg>

                            </a>
                            <div class="collapse" id="collapseFaq4">
                                <div class="da nb mm">
                                    La eVisa de Kenia es un documento oficial que permite a los viajeros ingresar a Kenia. Solo asegúrate de que estás <strong>viajando durante el período de validez de la eVisa</strong>        </div>
                            </div>
                        </div>
                        <div class="kd kh lt bau">
                            <a class="go iy jd" href="javascript:void(0)" data-collapse-btn="" role="button" aria-expanded="false" aria-controls="collapseFaq5" onclick="window.ivisalog.track('faq_click', {
               faq_text: '¿Cómo funcionan los tiempos de procesamiento?'
             })">
                                <h3 class="ny baw nb bap">¿Cómo funcionan los tiempos de procesamiento?</h3>
                                <svg class="gl nb hu gx" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.29389 13.7081C9.68443 14.0986 10.3187 14.0986 10.7092 13.7081L16.7081 7.70924C17.0986 7.31869 17.0986 6.68444 16.7081 6.29389C16.3175 5.90334 15.6833 5.90334 15.2927 6.29389L10 11.5866L4.70728 6.29701C4.31673 5.90646 3.68248 5.90646 3.29193 6.29701C2.90139 6.68756 2.90139 7.32181 3.29193 7.71236L9.29076 13.7112L9.29389 13.7081Z"></path>
                                </svg>

                            </a>
                            <div class="collapse" id="collapseFaq5">
                                <div class="da nb mm">
                                    En iVisa, comprendemos que tu tiempo es valioso y nos esforzamos por brindarte el servicio más rápido posible. Nuestros tiempos de procesamiento se estiman en función de la duración promedio que los gobiernos tardan en procesar las solicitudes de visa. Estos tiempos estimados comienzan desde el momento en que recibimos toda la información correcta para tu solicitud hasta que recibes tu visa. Aunque trabajamos diligentemente para acelerar el proceso, es importante tener en cuenta que dependemos de los tiempos de procesamiento establecidos por las autoridades gubernamentales.        </div>
                            </div>
                        </div>
                        <div class="kd kh lt bau">
                            <a class="go iy jd" href="javascript:void(0)" data-collapse-btn="" role="button" aria-expanded="false" aria-controls="collapseFaq6" onclick="window.ivisalog.track('faq_click', {
               faq_text: '¿Con quién puedo hablar si tengo más preguntas?'
             })">
                                <h3 class="ny baw nb bap">¿Con quién puedo hablar si tengo más preguntas?</h3>
                                <svg class="gl nb hu gx" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.29389 13.7081C9.68443 14.0986 10.3187 14.0986 10.7092 13.7081L16.7081 7.70924C17.0986 7.31869 17.0986 6.68444 16.7081 6.29389C16.3175 5.90334 15.6833 5.90334 15.2927 6.29389L10 11.5866L4.70728 6.29701C4.31673 5.90646 3.68248 5.90646 3.29193 6.29701C2.90139 6.68756 2.90139 7.32181 3.29193 7.71236L9.29076 13.7112L9.29389 13.7081Z"></path>
                                </svg>

                            </a>
                            <div class="collapse" id="collapseFaq6">
                                <div class="da nb mm">
                                    ¿Necesitas ayuda? Visita nuestro <strong><a href="/" target="_blank" rel="nofollow">centro de ayuda</a></strong> o envíanos un mensaje por <strong><a href="https://wa.link/3yu2lb" target="_blank" rel="nofollow">WhatsApp</a></strong>.        </div>
                            </div>
                        </div>
                        <div class="kd kh lt bau">
                            <a class="go iy jd" href="javascript:void(0)" data-collapse-btn="" role="button" aria-expanded="false" aria-controls="collapseFaq7" onclick="window.ivisalog.track('faq_click', {
               faq_text: '¿Dónde puedo leer más?'
             })">
                                <h3 class="ny baw nb bap">¿Dónde puedo leer más?</h3>
                                <svg class="gl nb hu gx" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.29389 13.7081C9.68443 14.0986 10.3187 14.0986 10.7092 13.7081L16.7081 7.70924C17.0986 7.31869 17.0986 6.68444 16.7081 6.29389C16.3175 5.90334 15.6833 5.90334 15.2927 6.29389L10 11.5866L4.70728 6.29701C4.31673 5.90646 3.68248 5.90646 3.29193 6.29701C2.90139 6.68756 2.90139 7.32181 3.29193 7.71236L9.29076 13.7112L9.29389 13.7081Z"></path>
                                </svg>

                            </a>
                            <div class="collapse" id="collapseFaq7">
                                <div class="da nb mm">
                                    <ol>
                                        <li><a href="/kenia/c/visitar-kenia-sin-visa-guia-para-los-viajeros-que-no-necesitan-visa">Visitar Kenia sin visa: Guía para los viajeros que no necesitan visa</a> </li>
                                        <li><a href="/kenia/c/visa-keniana-para-colombianos">VISA KENIANA PARA COLOMBIANOS</a> </li>
                                        <li><a href="/kenia/c">Ver todo</a> </li>
                                    </ol>        </div>
                            </div>
                        </div>
                        <div class="kd kh lt bau">
                            <a class="go iy jd" href="javascript:void(0)" data-collapse-btn="" role="button" aria-expanded="false" aria-controls="collapseFaq8" onclick="window.ivisalog.track('faq_click', {
               faq_text: 'Otras visas disponibles: Kenia?'
             })">
                                <h3 class="ny baw nb bap">Otras visas disponibles: Kenia?</h3>
                                <svg class="gl nb hu gx" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.29389 13.7081C9.68443 14.0986 10.3187 14.0986 10.7092 13.7081L16.7081 7.70924C17.0986 7.31869 17.0986 6.68444 16.7081 6.29389C16.3175 5.90334 15.6833 5.90334 15.2927 6.29389L10 11.5866L4.70728 6.29701C4.31673 5.90646 3.68248 5.90646 3.29193 6.29701C2.90139 6.68756 2.90139 7.32181 3.29193 7.71236L9.29076 13.7112L9.29389 13.7081Z"></path>
                                </svg>

                            </a>
                            <div class="collapse" id="collapseFaq8">
                                <div class="da nb mm">
                                    <ul>
                                        <li><a href="/kenia/p/e-visa">ETA</a></li>
                                        <li><a href="/a/kenia">ETA Application</a></li>
                                    </ul>        </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection
