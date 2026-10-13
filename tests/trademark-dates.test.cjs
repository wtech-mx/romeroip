const { test } = require('node:test');
const assert = require('node:assert/strict');
const dates = require('../public/assets/js/trademark-dates.js');

test('two digit years and month names produce the same stored date', () => {
    for (const input of ['02/23/23', 'Feb/23/23', 'February/23/2023', '022323', '2023-02-23']) {
        assert.equal(dates.parse(input), '2023-02-23');
        assert.equal(dates.format(input), 'Feb/23/2023');
    }
    assert.equal(dates.parse('01/01/00'), '2000-01-01');
    assert.equal(dates.parse('12/31/1999'), '1999-12-31');
});

test('invalid dates are rejected instead of rolling into another month', () => {
    for (const input of ['02/31/23', '02/29/23', '01/00/23', '13/01/23', '2023-04-31', 'Foo/23/23', 'not a date']) {
        assert.equal(dates.parse(input), null);
    }
    assert.equal(dates.parse('02/29/24'), '2024-02-29');
    assert.equal(dates.parse(''), '');
});

 test('month-first display keeps ambiguous numeric dates in the requested order', () => {
    assert.equal(dates.parse('07/06/23'), '2023-07-06');
    assert.equal(dates.format('07/06/23'), 'Jul/06/2023');
    assert.equal(dates.parse('Jul/06/2023'), '2023-07-06');
    assert.equal(dates.parse('070623'), '2023-07-06');
 });
