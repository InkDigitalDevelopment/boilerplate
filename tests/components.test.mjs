import assert from 'node:assert/strict';
import fs from 'node:fs';
import path from 'node:path';
import test from 'node:test';

const themeRoot = path.resolve('wp-content/themes/inkwell');
const componentSlugs = [
  'hero-split',
  'logo-strip',
  'icon-grid',
  'process-steps',
  'team-grid',
  'featured-case-study',
  'latest-posts',
  'form-content',
  'anchor-nav',
  'content-columns',
  'full-width-media',
  'quote-feature',
];

function fieldKeys(fields) {
  return fields.flatMap(field => [field.key, ...fieldKeys(field.sub_fields || [])]);
}

function fieldNames(fields) {
  return fields.flatMap(field => [field.name, ...fieldNames(field.sub_fields || [])]);
}

test('the design library contains 12 complete and correctly wired ACF blocks', () => {
  const keys = [];

  for (const slug of componentSlugs) {
    const directory = path.join(themeRoot, 'blocks', slug);
    const block = JSON.parse(fs.readFileSync(path.join(directory, 'block.json'), 'utf8'));
    const groups = JSON.parse(fs.readFileSync(path.join(directory, 'acf-fields.json'), 'utf8'));
    const renderer = fs.readFileSync(path.join(directory, 'render.php'), 'utf8');

    assert.equal(block.name, `inkwell/${slug}`);
    assert.equal(block.acf.renderTemplate, 'render.php');
    assert.equal(block.category, 'inkwell-components');
    assert.equal(groups.length, 1);
    assert.equal(groups[0].location[0][0].value, block.name);
    assert(groups[0].fields.length > 0);
    assert(renderer.includes('<section') || renderer.includes('<nav'));
    for (const name of fieldNames(groups[0].fields)) {
      assert(renderer.includes(name), `${slug} renderer does not use ${name}`);
    }

    keys.push(groups[0].key, ...fieldKeys(groups[0].fields));
  }

  assert.equal(new Set(keys).size, keys.length, 'ACF group and field keys must be unique');
});
