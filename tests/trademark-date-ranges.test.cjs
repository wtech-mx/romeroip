const test = require('node:test');
const assert = require('node:assert/strict');
const ranges = require('../public/assets/js/trademark-date-ranges.js');
test('single dates and inclusive ranges retain exact stored endpoints', () => {
  assert.deepEqual(ranges.parse('07/06/23'), {from:'2023-07-06',to:'2023-07-06'});
  assert.deepEqual(ranges.parse('Jul/06/2023 — Jul/10/2023'), {from:'2023-07-06',to:'2023-07-10'});
  assert.deepEqual(ranges.parse('2024-02-29 to 2024-03-01'), {from:'2024-02-29',to:'2024-03-01'});
});
test('one-sided ranges and clear round-trip without inventing limits', () => {
  for(const range of [{from:'2023-07-06',to:''},{from:'',to:'2023-07-06'},{from:'',to:''}]) assert.deepEqual(ranges.parse(ranges.format(range)),range);
});
test('impossible and reversed ranges are rejected', () => {
  for(const input of ['02/31/2026','07/10/23 — 07/06/23','bad date','07/06/23 — 07/10/23 — 07/12/23']) assert.equal(ranges.parse(input),null);
});
