"use strict";

const fs = require('fs');

function isexe(path, options, cb) {
  fs.stat(path, function (er, stat) {
    cb(er, er ? false : checkStat(stat, options || {}));
  });
}

function sync(path, options) {
  return checkStat(fs.statSync(path), options || {});
}

function checkStat(stat, options) {
  return stat.isFile() && checkMode(stat, options);
}

function checkMode(stat, options) {
  const mod = stat.mode;
  const uid = stat.uid;
  const gid = stat.gid;

  const myUid = (options && options.uid !== undefined)
    ? options.uid
    : (typeof process.getuid === 'function' ? process.getuid() : null);
  const myGid = (options && options.gid !== undefined)
    ? options.gid
    : (typeof process.getgid === 'function' ? process.getgid() : null);

  const u = parseInt('100', 8);
  const g = parseInt('010', 8);
  const o = parseInt('001', 8);
  const ug = u | g;

  const ret = (mod & o) ||
    ((mod & g) && gid === myGid) ||
    ((mod & u) && uid === myUid) ||
    ((mod & ug) && myUid === 0);

  return !!ret;
}

module.exports = {
  isexe,
  sync,
  checkStat,
  checkMode
};
