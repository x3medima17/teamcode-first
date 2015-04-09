#include <fstream>
#include <iostream>
#define rep(x,y,z) for (int x=y;x<=z;x++)
using namespace std;
ifstream fin("robotii.in");
ofstream fout("robotii.out");
class coor{
      public:
             int x,y;
             }c1[1500],c2[1500];

int n,m,an,s,q,s1,s2,t,g[255][255],c,p;
int main()
{
    int x1[]={1,1,-1,-1,2,2,-2,-2};
    int y1[]={-2,2,-2,2,-1,1,-1,1};
    
    fin>>n>>m>>s>>t>>q;
    n++;
    m++;
    s++;
    t++;
    rep(i,0,n+2)
    {
              g[i][0]=1;
              g[i][1]=1;
              g[i][m+1]=1;
              g[i][m+2]=1;
              }
    rep(j,0,m+2)
    {
                g[0][j]=1;
                g[1][j]=1;
                g[n+1][j]=1;
                g[n+2][j]=1;
                }   
    rep(ts,1,q)
    {
              fin>>c1[1].x>>c1[1].y;
              c1[1].x++;
              c1[1].y++;
              s1=1;
              p=0;
              if (c1[1].x!=s || c1[1].y!=t) {
              while (s1!=0 && g[s][t]==0)
              {
                    p++;
                    s2=0;
                    rep(i,1,s1)
                    rep(j,0,7)
                              if (g[c1[i].x+x1[j]][c1[i].y+y1[j]]==0) {
                                                                    s2++;
                                                                    c2[s2].x=c1[i].x+x1[j];
                                                                    c2[s2].y=c1[i].y+y1[j];
                                                                    g[c2[s2].x][c2[s2].y]=p;
                                                                    }
                    s1=s2;
                    rep(i,1,s1)
                    c1[i]=c2[i];
                    }
              if (g[s][t]==0) {
                              fout<<-1; return 0;
                              } else an+=g[s][t];
              rep(i,2,n)
              rep(j,2,m)
              g[i][j]=0;
                              }
              }
              fout<<an<<endl;     
              }                                       
