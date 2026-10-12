const { test } = require('node:test');
const assert = require('node:assert/strict');
const dates = require('../public/assets/js/trademark-dates.js');

test('two digit years and month names produce the same stored date', () => {
    for (const input of ['23/02/23', '23 Feb 23', '23 February 2023', '230223', '2023-02-23']) {
        assert.equal(dates.parse(input), '2023-02-23');
        assert.equal(dates.format(input), '23 Feb 2023');
    }
    assert.equal(dates.parse('01/01/00'), '2000-01-01');
    assert.equal(dates.parse('31/12/1999'), '1999-12-31');
});

test('invalid dates are rejected instead of rolling into another month', () => {
    for (const input of ['31/02/23', '29/02/23', '00/01/23', '01/13/23', '2023-04-31', '23 Foo 23', 'not a date']) {
        assert.equal(dates.parse(input), null);
    }
    assert.equal(dates.parse('29/02/24'), '2024-02-29');
    assert.equal(dates.parse(''), '');
});
