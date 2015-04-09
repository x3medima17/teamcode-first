#include<iostream>
#include<fstream>
#include<list>
#define read(x) for(i=1;i<=x;i++)
using namespace std;
ifstream fin("robotii.in");
ofstream fout("robotii.out");

//list <int> l;
struct li{
       list <int> i,j;
       }l;
struct st{
       int x,y;
       }b[10005];
int n,m,i,k,j,s,t,a[260][260],q,to=0,curr=0;

void see(){
     int i,j;
        for(i=1;i<=n;i++){
                     for(j=1;j<=m;j++)cout<<a[i][j]<<" ";
                     cout<<endl;
                     }
     }
int chc(int i, int j){
 int k=0;
 if (i<1 || i>n || j<1 || j>m) return k;
 if(a[i][j]!=0) return k;
 k=1;
 return k;
    
}
void spread(int i, int j){
     int ni,nj;
     int k=a[i][j]+1;
     ni = i-2; nj=j+1;
     if(chc(ni,nj)==1) {
                  a[ni][nj]=k; 
                  l.i.push_back(ni); 
                  l.j.push_back(nj);
                  }
     ni = i-1; nj=j+2;
     if(chc(ni,nj)==1) {
                  a[ni][nj]=k; 
                  l.i.push_back(ni); 
                  l.j.push_back(nj);
                  }
     ni = i+1; nj=j+2;
     if(chc(ni,nj)==1) {
                  a[ni][nj]=k; 
                  l.i.push_back(ni); 
                  l.j.push_back(nj);
                  }
     ni = i+2; nj=j+1;
     if(chc(ni,nj)==1) {
                  a[ni][nj]=k; 
                  l.i.push_back(ni); 
                  l.j.push_back(nj);
                  }
     ni = i+2; nj=j-1;
     if(chc(ni,nj)==1) {
                  a[ni][nj]=k; 
                  l.i.push_back(ni); 
                  l.j.push_back(nj);
                  }
     ni = i+1; nj=j-2;
     if(chc(ni,nj)==1) {
                  a[ni][nj]=k; 
                  l.i.push_back(ni); 
                  l.j.push_back(nj);
                  }
     ni = i-1; nj=j-2;
     if(chc(ni,nj)==1) {
                  a[ni][nj]=k; 
                  l.i.push_back(ni); 
                  l.j.push_back(nj);
                  }
     ni = i-2; nj=j-1;
     if(chc(ni,nj)==1) {
                  a[ni][nj]=k; 
                  l.i.push_back(ni); 
                  l.j.push_back(nj);
                  }
                  //see();
                  //cout<<endl;
     }
void wave(){
     int k=0,ni,nj;
     while(!l.i.empty()){
                         k++;
                         ni=l.i.front();
                         nj=l.j.front();
                         //cout<<ni<<" - "<<nj<<endl;
                       spread(ni,nj);
                       l.i.pop_front();
                       l.j.pop_front();
                
                       }
     }
int main(){
   fin>>n>>m>>s>>t>>q;
   read(q) fin>>b[i].x>>b[i].y;
  // read(q) cout<<b[i].x<<" "<<b[i].y<<endl;
   a[s][t]=1;
   //cout<<s<<t;
   l.i.push_back(s);
   l.j.push_back(t);
   wave();
  // see();
   //cout<<endl;
   for(i=1;i<=q;i++){
                     curr = a[b[i].x][b[i].y]-1;
                     if (curr==-1) {to=-1; break;}
                     to+=curr;
                     }
                     fout<<to<<endl;
                  //   syste("pause");
  
    
}
