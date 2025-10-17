const m = require('../mode');
const path = require('path');

const file = path.join(__dirname, '..', 'composer.json');
const missing = path.join(__dirname, 'no-such-file.txt');

console.log('Testing file:', file);
try {
  console.log('sync ->', m.sync(file, {}));
} catch (e) {
  console.error('sync error ->', e.message);
}

m.isexe(file, {}, (err, ok) => {
  console.log('isexe callback -> err:', err ? err.message : null, ' ok:', ok);
  // test missing file
  m.isexe(missing, {}, (err2, ok2) => {
    console.log('missing file isexe -> err:', err2 ? err2.message : null, ' ok:', ok2);
    process.exit(0);
  });
});
