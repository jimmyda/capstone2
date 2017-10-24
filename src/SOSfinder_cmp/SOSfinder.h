#pragma once
#include <iostream>
#include <mysql/mysql.h>
#include <cstdio>
#include <stdlib.h>
#include <cstdlib>
#include <fstream>
#include <string>
#include <vector>
#include <set>
#include <algorithm>
#include <iterator>
#include <time.h>

#define D_SUCC 15
#define D_FAIL 14


typedef struct stSignature {
	std::string szSigName;
	std::string szSigCVENum;
	std::string szSignature;
}stSig;

char instruct[44][10] = { "mov", "add", "mul", "div", "cbw", "cwd", "inc", "dec", "adc", "sub", "sbb", "imul", "idiv", "push",
"pop", "and", "or", "xor", "not", "neg", "shl", "ror", "cmp", "jmp", "call", "ret","je", "jz", "jl", "jnge", "jbe", "jna", "jb", "jnae",
"jp", "jpe", "jo", "js", "loop", "str", "ldr", "blx", "bl", "b." };