const test = require('node:test');
const assert = require('node:assert/strict');
const vm = require('node:vm');
const fs = require('node:fs');
const source = fs.readFileSync(require.resolve('../public/assets/js/trademark-columns.js'), 'utf8');
function harness() {
  const status = {hidden:true,textContent:''};
  const events = new Map(), requests = [], timers = new Map(); let clock = 0, timerId = 0;
  const definitions = Object.fromEntries(['select','edit','our_ref','trademark','application_date','int_registration_no'].map(key => [key,{label:key,width:100,defaultVisible:!key.includes('date') && key !== 'int_registration_no'}]));
  const config = {definitions,preferences:{order:Object.keys(definitions),visible:Object.keys(definitions).slice(0,4),widths:{}},url:'/preferences',token:'test'};
  const document = {
    getElementById(id) {return id === 'tm-column-config' ? {textContent:JSON.stringify(config)} : null;},
    querySelectorAll(selector) {return selector === '[data-preferences-status]' ? [status] : [];},
    querySelector() {return null;}, addEventListener(name,callback) {events.set(name,callback);}
  };
  const context = {document,window:{addEventListener(){}},fetch(url,options) {return new Promise((resolve,reject) => requests.push({resolve,reject,body:JSON.parse(options.body)}));},
    setTimeout(callback,delay) {const id=++timerId;timers.set(id,{at:clock+delay,callback});return id;}, clearTimeout(id){timers.delete(id);}};
  vm.runInNewContext(source,context);
  return {status,requests,
    reset() {events.get('click')({target:{closest(selector){return selector === '[data-columns-reset]' ? {} : null;}}});},
    tick(ms) {clock+=ms;for(const [id,timer] of [...timers]) if(timer.at<=clock){timers.delete(id);timer.callback();}}
  };
}
const flush = () => new Promise(resolve => setImmediate(resolve));
test('confirmation waits for successful save and disappears after three seconds',async()=>{
  const ui=harness(); ui.reset(); assert.equal(ui.status.hidden,true);
  assert.deepEqual(ui.requests[0].body.visible,['select','edit','our_ref','trademark']);
  ui.requests[0].resolve({ok:true}); await flush();
  assert.equal(ui.status.textContent,'Column preferences saved.'); assert.equal(ui.status.hidden,false);
  ui.tick(2999); assert.equal(ui.status.hidden,false); ui.tick(1); assert.equal(ui.status.hidden,true);
});
test('another saved change restarts the confirmation timer',async()=>{
  const ui=harness();ui.reset();ui.requests[0].resolve({ok:true});await flush();ui.tick(2000);
  ui.reset();assert.equal(ui.status.hidden,true);ui.requests[1].resolve({ok:true});await flush();
  ui.tick(1000);assert.equal(ui.status.hidden,false);ui.tick(1999);assert.equal(ui.status.hidden,false);ui.tick(1);assert.equal(ui.status.hidden,true);
});
test('stale acknowledgements and failed requests never claim the current change was saved',async()=>{
  const ui=harness();ui.reset();ui.reset();assert.equal(ui.requests.length,1);
  ui.requests[0].resolve({ok:true});await flush();assert.equal(ui.status.hidden,true);assert.equal(ui.requests.length,2);
  ui.requests[1].resolve({ok:false});await flush();assert.notEqual(ui.status.textContent,'Column preferences saved.');assert.match(ui.status.textContent,/Unable to save/);
  ui.reset();ui.requests[2].resolve({ok:true});await flush();assert.equal(ui.status.textContent,'Column preferences saved.');
});
