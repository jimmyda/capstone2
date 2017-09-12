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

