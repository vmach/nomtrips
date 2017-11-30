import { Component } from '@angular/core';
import { EnvironmentService } from './environment.service';
declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  providers: [EnvironmentService]
})
export class AppComponent {  
  constructor (private environmentService: EnvironmentService) {
    environmentService.init();
  }
}
