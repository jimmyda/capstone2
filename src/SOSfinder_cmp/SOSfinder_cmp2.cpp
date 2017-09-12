#include "SOSfinder.h"

int TargetTokenize(std::fstream& fsTarget, std::string &szTargetString);
int GetTarget(std::fstream& fsTarget, std::string szTargetFileName, std::string &szTargetString);
int CheckLength(std::string szSigStr, std::string& szTargetStr, int& iSigSize);
double CmpSigTarget(stSignature stSign, std::string szTargetStr, int iWinSize);
int GetSignature(MYSQL_ROW row, stSig &stSign);
double CmpSigTarget_contain(stSignature stSign, std::string szTargetStr, int iWinSize);
double BinSearch(int iFront, int iLast, std::string szTargetStr, stSignature stSign, int iLenOfWin, int iWindowSize, int iCompLen);
int GetSimilarity(std::string &szTargetStr, int iWindowSize);
int InsertSignature(std::string szFileName);


int main(int argc, char* argv[]) {
	int iRtn;
	std::string szTargetString;
	std::fstream fsTargetFile;	
	int iWindowSize = 8;
	
//	CASE1 : use when you want to check assembly file's vulnerability
//	compile : g++ -o SOSfinder SOSfinder_cmp2.cpp -lmysqlclient 
// 	usage : SOSfinder <input file name> 
	
	if (argc != 2) {
		std::cout << "Usage : SOSfinder <input file name>" << std::endl;
		return -1;
	}

	iRtn = GetTarget(fsTargetFile, argv[1], szTargetString);
	if (iRtn == D_FAIL) return -1;

	GetSimilarity(szTargetString, iWindowSize);
	if (iRtn == D_FAIL) return -1;


//	CASE2 : use when you want to insert data to DB
//	compile : g++ -o SOSfinder_input SOSfinder_cmp2.cpp -lmysqlclient 
//	usage : SOSfinder_input <input file name>
/*
	InsertSignature(argv[1]);
	if (argc != 2) {
		std::cout << "Usage : SOSfinder_input <input file name>" << std::endl;
		return -1;
	}

*/
	return 0;

}

int TargetTokenize(std::fstream& fsTarget, std::string& szTargetString)
{
	std::string str;
	int cnt;

	while (getline(fsTarget, str))
	{
		if (str.find("mov") != -1)
			szTargetString += "mov";
		else if (str.find("add") != -1)
			szTargetString += "add";
		else if (str.find("mul") != -1)
			szTargetString += "mul";
		else if (str.find("div") != -1)
			szTargetString += "div";
		else if (str.find("cbw") != -1)
			szTargetString += "cbw";
		else if (str.find("cwd") != -1)
			szTargetString += "cwd";
		else if (str.find("inc") != -1)
			szTargetString += "inc";
		else if (str.find("dec") != -1)
			szTargetString += "dec";
		else if (str.find("adc") != -1)
			szTargetString += "adc";
		else if (str.find("sub") != -1)
			szTargetString += "sub";
		else if (str.find("sbb") != -1)
			szTargetString += "sbb";
		else if (str.find("imul") != -1)
			szTargetString += "imul";
		else if (str.find("idiv") != -1)
			szTargetString += "idiv";
		else if (str.find("push") != -1)
			szTargetString += "push";
		else if (str.find("pop") != -1)
			szTargetString += "pop";
		else if (str.find("and") != -1)
			szTargetString += "and";
		else if (str.find("or") != -1)
			szTargetString += "or";
		else if (str.find("xor") != -1)
			szTargetString += "xor";
		else if (str.find("not") != -1)
			szTargetString += "not";
		else if (str.find("neg") != -1)
			szTargetString += "neg";
		else if (str.find("shl") != -1)
			szTargetString += "shl";
		else if (str.find("ror") != -1)
			szTargetString += "ror";
		else if (str.find("cmp") != -1)
			szTargetString += "cmp";
		else if (str.find("jmp") != -1)
			szTargetString += "jmp";
		else if (str.find("call") != -1)
			szTargetString += "call";
		else if (str.find("ret") != -1)
			szTargetString += "ret";
		else if ((str.find("je") != -1) || (str.find("jz") != -1))
			szTargetString += "je";
		else if ((str.find("jl") != -1) || (str.find("jnge") != -1))
			szTargetString += "jl";
		else if ((str.find("jbe") != -1) || (str.find("jna") != -1))
			szTargetString += "jbe";
		else if ((str.find("jb") != -1) || (str.find("jnae") != -1))
			szTargetString += "jb";
		else if ((str.find("jp") != -1) || (str.find("jpe") != -1))
			szTargetString += "jp";
		else if (str.find("jo") != -1)
			szTargetString += "jo";
		else if (str.find("js") != -1)
			szTargetString += "js";
		else if (str.find("loop") != -1)
			szTargetString += "loop";
		else if (str.find("str") != -1)
			szTargetString += "str";
		else if (str.find("ldr") != -1)
			szTargetString += "ldr";
		else if (str.find("blx") != -1)
			szTargetString += "blx";
		else if (str.find("bl") != -1)
			szTargetString += "bl";
		else if (str.find("b.") != -1)
			szTargetString += "b";
		else
		{
			szTargetString += "instruction\n";
			continue;
		}

		if ((str.find(",") != -1) && (str.find("#") != -1))
		{
			cnt = 0;
			for (size_t i = 0; i < str.length(); i++)
			{
				if (str.at(i) == ',')
					cnt++;
			}
			szTargetString += "\t";
			for (int j = 0; j < cnt; j++)
				szTargetString += "r";
			szTargetString += "c";
		}
		else if ((str.find(",") != -1) && (str.find("#") == -1))
		{
			cnt = 0;
			for (size_t i = 0; i < str.length(); i++)
			{
				if (str.at(i) == ',')
					cnt++;
			}
			szTargetString += "\tr";
			for (int j = 0; j < cnt; j++)
				szTargetString += "r";
		}
		szTargetString += "\n";
	}

	return D_SUCC;
}

int GetTarget(std::fstream& fsTarget, std::string szTargetFileName, std::string &szTargetString) {

	int iRtn;

	// open target file
	fsTarget.open(szTargetFileName.c_str(), std::ios::in);
	
	// check target file validation 
	if (!fsTarget) {
		std::cout << "Target File open error.." << std::endl;
		return D_FAIL;
	}

	// store target file to szTargetString
	iRtn = TargetTokenize(fsTarget, szTargetString);
	if (iRtn == D_FAIL) {
		std::cout << "Target File Tokenize error.." << std::endl;
	}

	// close target file;
	fsTarget.close();

	return D_SUCC;
}

int CheckLength(std::string szSigStr, std::string& szTargetStr, int& iSigSize) {
	
//	check the length of Target file and select compare WindowSize
//	1SigSize = compare WindowSize

	if (szTargetStr.length() < szSigStr.length()) {
		iSigSize = szTargetStr.length();
		szSigStr = szSigStr.substr(0, iSigSize);
	} 
	else {
		iSigSize = szSigStr.length();
	}

	return D_SUCC;
}



int GetSignature(MYSQL_ROW row, stSig &stSign) {

//	get Signature info from DB fetch row
	
	// row[0] => name_of_vuln 
	// row[1] => number_of_CVE  
	// row[2] => Tokenized_binary_code_of_vuln
	stSign.szSigName = row[0];
	stSign.szSigCVENum = row[1];
	stSign.szSignature = row[2];
	
	return D_SUCC;
}

int GetSimilarity(std::string &szTargetStr, int iWindowSize) {

	int iRtn;
	int iMaxJI = -1;
	int iSigSize;
	double dResultJaccard = 0;
	double dTempJaccard = 0;
	double dJaccardOfCVE = 0;
	std::string::size_type iStart = 0;
	stSig stSigObject;
	
	MYSQL_RES *res;	// the results
	MYSQL_ROW row;	// the results row (line by line)

	std::string szDBQuery = "SELECT * FROM vuln_t order by Name";

	//DB connect
	MYSQL *connection = mysql_init(NULL);
	my_bool reconnect = true;
	mysql_options(connection, MYSQL_OPT_RECONNECT, &reconnect);
	
	if (!mysql_real_connect(connection, "localhost", "root", "1234", "vuln", 0, NULL, 0)) {
		std::cout << "DB Conection error : " << mysql_error(connection) << "\n" << std::endl;
		exit(1);
	}
	if (mysql_query(connection, szDBQuery.c_str()))
	{
		std::cout << "MySQL query error : " << mysql_error(connection) << "\n" << std::endl;
		exit(1);
	}
	
	res = mysql_store_result(connection);
	
	// value for check CVENum
	std::string szFrontCVE= "";
	std::string szCurrentCVE;


	// make output with .json file format
	//std::cout << "{" << std::endl;
	//std::cout << "\t\"vuln\": [" << std::endl;
	// make output with .tsv file
	std::cout << "letter\tfrequency" << std::endl;
	while ((row = mysql_fetch_row(res)) != NULL) {
		
		iRtn = GetSignature(row,stSigObject);		 
		if (iRtn == D_FAIL) {
			std::cout << "Read SignatureFile from DB error.." << std::endl;
		}

		szCurrentCVE = stSigObject.szSigCVENum;
		if(szFrontCVE != "" && szFrontCVE != szCurrentCVE){
			std::cout << szFrontCVE << "\t" << dJaccardOfCVE << std::endl;			
//			std::cout << "\t\t{ " << "\"CVEnumber\"" << ": \"" << stSigObject.szSigCVENum << "\",\"similarity\"" <<": " << dJaccardOfCVE << " }," << std::endl;
			dJaccardOfCVE = 0;
		}

		dResultJaccard = 0;
		iStart = 0;		
		CheckLength(stSigObject.szSignature, szTargetStr, iSigSize);
		if(stSigObject.szSignature.length() == 0 || szTargetStr.length() == 0)
			continue;		
		int iFront = 0;
		int iLast = szTargetStr.length();
		int iLengthOfWindow = szTargetStr.length()/2 + iSigSize;
		if(CmpSigTarget_contain(stSigObject, szTargetStr, iWindowSize) >= 0.6)		
			dResultJaccard = BinSearch(iFront, iLast, szTargetStr, stSigObject, iLengthOfWindow, iWindowSize,iSigSize);
		dJaccardOfCVE = dResultJaccard > dJaccardOfCVE ? dResultJaccard : dJaccardOfCVE;
		szFrontCVE = szCurrentCVE;
	}
	std::cout << stSigObject.szSigCVENum << "\t" << dJaccardOfCVE << std::endl;
//	std::cout << "\t\t{ " << "\"CVEnumber\"" << ": \"" << stSigObject.szSigCVENum << "\",\"similarity\"" <<": " << dJaccardOfCVE << " }" << std::endl << "\t]"<< std::endl << "}" << std::endl;
	dJaccardOfCVE = 0;
		
	return D_SUCC;
}

double BinSearch(int iFront, int iLast, std::string szTargetStr, stSignature stSign ,int iLenOfWin, int iWindowSize, int iCompLen){	
	double dResultJaccard,dTempJaccard;
	double dTempJaccardFront= 0;
	double dTempJaccardBack = 0;
	
	if(iLenOfWin <= 2.6 * stSign.szSignature.length()){

		int iStart = iFront;
		while( iStart + iCompLen  <= iLast){\

			dTempJaccard = CmpSigTarget(stSign, szTargetStr.substr(iStart, iCompLen), iWindowSize);
			iStart = szTargetStr.find("\n", iStart + 1);
			dResultJaccard = dResultJaccard > dTempJaccard ? dResultJaccard : dTempJaccard;

		}
		return	dResultJaccard;
	}

	if(CmpSigTarget_contain(stSign, szTargetStr.substr(iFront, iLenOfWin), iWindowSize) > 0.6)
		dTempJaccardFront = BinSearch(iFront, iFront + iLenOfWin, szTargetStr, stSign, iLenOfWin/2, iWindowSize,iCompLen);		

	if(CmpSigTarget_contain(stSign, szTargetStr.substr(iLast - iLenOfWin, iLenOfWin), iWindowSize) > 0.6)
		dTempJaccardBack = BinSearch(iLast - iLenOfWin, iLast, szTargetStr, stSign, iLenOfWin/2, iWindowSize,iCompLen);
	dResultJaccard = dTempJaccardFront > dTempJaccardBack ? dTempJaccardFront : dTempJaccardBack;
	return dResultJaccard;
	
}

double CmpSigTarget(stSignature stSign, std::string szTargetStr, int iWinSize) {

	int iNGram,iFlag;
	int iCounter = 0;
	std::string::size_type iCursor = 0;
	std::string::size_type iPrev = 0;
	std::string::size_type iStart = 0;
	double dJaccardIndex;
	std::string szNGramElement;
	std::set<std::string> setSigGram;
	std::set<std::string> setTargetGram;
	std::vector<std::string> vIntersection;

//	construct gram set for Signature
	iNGram = iWinSize;
	iFlag = 0;
	iStart = iPrev;  
	while ((iCursor = stSign.szSignature.find("\n", iStart + 1) < stSign.szSignature.length())) {
		
		szNGramElement = "";		
		
		iStart = stSign.szSignature.find("\n", iStart + 1);
		iPrev = iStart;
		
		iCounter = 1;
		
		while (iCounter <= iNGram) {
				 
			iCursor = stSign.szSignature.find("\n", iPrev + 1);
			if(iCursor > stSign.szSignature.length()){
				iFlag = 1;
				break;
			}
			
			szNGramElement += stSign.szSignature.substr(iPrev, iCursor - iPrev);
			iPrev = iCursor;
			iCounter ++;				
		}
		if(iFlag)	break;
		setSigGram.insert(szNGramElement);
	}

//	construct gram set for TargetFile
	iStart = 0;
	iPrev = 0;
	iCursor = 0;
	iFlag = 0;

	while ((iCursor = szTargetStr.find("\n", iStart + 1) < szTargetStr.length())) {
		
		szNGramElement = "";		

		iStart = szTargetStr.find("\n", iStart + 1);
		iPrev = iStart;
		
		iCounter = 1;
		
		while (iCounter <= iNGram) {
				 
			iCursor = szTargetStr.find("\n", iPrev + 1);
			if(iCursor > szTargetStr.length()){
				iFlag = 1;
				break;
			}
			
			szNGramElement += szTargetStr.substr(iPrev, iCursor - iPrev);
			iPrev = iCursor;
			iCounter ++;				
		}
		if(iFlag)	break;
		setTargetGram.insert(szNGramElement);
	}
	
//	calculate set intersection & Jaccard Index;
	std::set_intersection(setSigGram.begin(), setSigGram.end(), setTargetGram.begin(), setTargetGram.end(), std::back_inserter(vIntersection));
		
	dJaccardIndex = (double)vIntersection.size() / ((double)setSigGram.size() + (double)setTargetGram.size() - (double)vIntersection.size());

	return dJaccardIndex;
}

double CmpSigTarget_contain(stSignature stSign, std::string szTargetStr, int iWinSize) {
	//jaccard containment
	int iNGram,iFlag;
	int iCounter = 0;
	std::string::size_type iCursor = 0;
	std::string::size_type iPrev = 0;
	std::string::size_type iStart = 0;
	double dJaccardContain;
	std::string szNGramElement;
	std::set<std::string> setSigGram;
	std::set<std::string> setTargetGram;
	std::vector<std::string> vIntersection;

	//construct gram set
	iNGram = iWinSize;
	iFlag = 0;
	iStart = iPrev;
	while ((iCursor = stSign.szSignature.find("\n", iStart + 1) < stSign.szSignature.length())) {
		
		szNGramElement = "";
		
		iStart = stSign.szSignature.find("\n", iStart + 1);
		iPrev = iStart;
		
		iCounter = 1;
		
		while (iCounter <= iNGram) {
			iCursor = stSign.szSignature.find("\n", iPrev + 1);
			if(iCursor > stSign.szSignature.length()){
				iFlag = 1;
				break;
			}
			
			szNGramElement += stSign.szSignature.substr(iPrev, iCursor - iPrev);
			iPrev = iCursor;
			iCounter ++;
		}
		if(iFlag)	break;
		setSigGram.insert(szNGramElement);		
	}
	
	iStart = 0;
	iPrev = 0;
	iCursor = 0;
	iFlag = 0;

	while ((iCursor = szTargetStr.find("\n", iStart + 1) < szTargetStr.length())) {
		
		szNGramElement = "";
		
		iStart = szTargetStr.find("\n", iStart + 1);
		iPrev = iStart;
		
		iCounter = 1;
		
		while (iCounter <= iNGram) {
			iCursor = szTargetStr.find("\n", iPrev + 1);
			if(iCursor > szTargetStr.length()){
				iFlag = 1;
				break;
			}
			
			szNGramElement += szTargetStr.substr(iPrev, iCursor - iPrev);
			iPrev = iCursor;
			iCounter ++;
		}
		if(iFlag)	break;
		setTargetGram.insert(szNGramElement);
	}
	
	std::set_intersection(setSigGram.begin(), setSigGram.end(), setTargetGram.begin(), setTargetGram.end(), std::back_inserter(vIntersection));
	
	dJaccardContain = (double)vIntersection.size() / (double)setSigGram.size();
	return dJaccardContain;
}

//---------------------------------------------------------------------------------------------------
int InsertSignature(std::string szFileName) {

	std::fstream fsSignatureFile;
		
	std::string FileName;
	std::string CVENum;
	std::string BinCode;
	std::string szLine;
	std::string szVulnName;
	FileName = szFileName;
	CVENum = "CVE-2014-1692";
	BinCode = "";

	fsSignatureFile.open(szFileName.c_str(), std::ios::in);
	TargetTokenize(fsSignatureFile, BinCode);

	//-----------------------------------------------------------------------------------------------
	std::string szDBQuery = "INSERT INTO vuln_t (Name,CVENum,BinCode) VALUES ('"+ szVulnName + FileName +"','"+ CVENum +"','"+ BinCode +"')";
	//-----------------------------------------------------------------------------------------------
	
	
	//DB connect
	MYSQL *connection = mysql_init(NULL);
	if (!mysql_real_connect(connection, "localhost", "root", "1234", "vuln", 0, NULL, 0)) {
		std::cout << "DB Conection error : " << mysql_error(connection) << "\n" << std::endl;
		exit(1);
	}
	if (mysql_query(connection, szDBQuery.c_str()))
	{
		std::cout << "MySQL query error : " << mysql_error(connection) << "\n" << std::endl;
		exit(1);
	}
	return D_SUCC;
}
