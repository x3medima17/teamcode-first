#include <iostream>
#include <fstream>
#include <vector>
#include <string>
#include <algorithm>
#define min(a,b) (a<b)?a:b

using namespace std;
ifstream fin ("BLOCURI.IN");
ofstream fout ("BLOCURI.OUT");

int p;
short n;
int a[23];
long long rez=0;
char tmp[23];

long howmany()
{
    long raspuns=0;
    short table[23];
    short m=0;
    for (short i=0; i<n; i++)
    {
        if (tmp[i]!=-1)
        {
            table[m]=i;
            m++;
        }
    }
    if (m==0) return 0;
    while (true)
    {
        tmp[table[0]]++;
        for (short i=1; i<m; i++)
        {
            tmp[table[i]]+=tmp[table[i-1]]/2;
            tmp[table[i-1]]%=2;
        }
        if (tmp[table[m-1]]==2)
            break;
        int sum=0;
        for (short i=0; i<m; i++)
        {
            sum+=(tmp[table[i]]==1)?a[table[i]]:0;
            if (sum>=p) break;
        }
        if (sum>=p)
        {
            raspuns++;
        }
    }
    for (int i=0; i<m; i++)
        tmp[table[i]]=0;
    return raspuns;
}

void process()
{
    for (short i=0; i<n; i++)
        tmp[i]=0;
    while (true)
    {
        tmp[0]++;
        for (short i=1; i<n; i++)
        {
            tmp[i]+=tmp[i-1]/2;
            tmp[i-1]%=2;
        }
        if (tmp[n-1]==2)
            break;
        int t=0;
        for (short i=0; i<n; i++)
        {
            t+=tmp[i];
        }
        if (t>n/2+1) continue;
        int sum=0;
        for (short i=0; i<n; i++)
        {
            sum+=(tmp[i]==1)?a[i]:0;
            if (sum>=p) break;
        }
        if (sum>=p)
        {
            for (short i=0; i<n; i++)
                tmp[i]*=-1;
            rez+=howmany();
            for (short i=0; i<n; i++)
                tmp[i]*=-1;
        }
    }
}

int main()
{
    fin>>n>>p;

    for (short i=0; i<n; i++)
        fin>>a[i];

    process();

    fout<<rez;

    return 0;
}
